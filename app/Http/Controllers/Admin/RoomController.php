<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Libraries\Notification;
use App\Libraries\Utilities;
use App\Models\Booking;
use App\Models\Room;
use App\Models\Tour;
use Carbon\Carbon;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class RoomController extends Controller
{
    protected $room;
    protected $notification;

    public function __construct(Room $room, Notification $notification)
    {
        $this->room = $room;
        $this->notification = $notification;
    }

    /**
     * Hiển thị danh sách Khách sạn.
     *
     * @param int $tourId
     * @return View|Response
     */
    public function index(int $tourId)
    {
        return view('admin.rooms.index', compact('tourId'));
    }

    /**
     * Thêm mới một Khách sạn vào tour.
     *
     * @param Request $request
     * @param int $tourId
     * @return JsonResponse
     */
    public function store(Request $request, int $tourId): JsonResponse
    {
        $request->validate($this->room->rules(), [], [
            'hotel_name' => __('client.hotel_name'),
            'name' => __('client.name'),
            'price' => __('client.price'),
            'number' => __('client.number'),
            'status' => __('client.status'),
        ]);

        try {
            $this->room->saveData($request, $tourId);
            $this->notification->setMessage('Đã thêm một Khách sạn mới thành công', Notification::SUCCESS);
        } catch (QueryException $e) {
            $message = $e->errorInfo[1] == '1062' ? 'Khách sạn đã tồn tại' : 'Thêm mới Khách sạn không thành công';
            $this->notification->setMessage($message, Notification::ERROR);
        } catch (Exception $e) {
            $this->notification->setMessage('Thêm mới Khách sạn không thành công', Notification::ERROR);
        }

        return response()->json($this->notification->getMessage());
    }

    /**
     * Cập nhật thông tin Khách sạn.
     *
     * @param Request $request
     * @param int $tourId
     * @param int $id
     * @return JsonResponse
     */
    public function update(Request $request, int $tourId, int $id): JsonResponse
    {
        // Validate request data
        $validatedData = $request->validate($this->room->rules($id), [
            'hotel_name' => __('client.hotel_name'),
            'name' => __('client.name'),
            'price' => __('client.price'),
            'number' => __('client.number'),
            'status' => __('client.status'),
        ]);

        try {
            // Save data
            $this->room->saveData($request, $tourId, $id);
            $this->notification->setMessage('Cập nhật thông tin Khách sạn thành công', Notification::SUCCESS);
        } catch (QueryException $e) {
            $message = $e->errorInfo[1] == '1062' ? 'Khách sạn đã tồn tại' : 'Cập nhật thông tin Khách sạn thất bại';
            $this->notification->setMessage($message, Notification::ERROR);
        } catch (Exception $e) {
            $this->notification->setMessage('Cập nhật thông tin Khách sạn thất bại', Notification::ERROR);
        }

        return response()->json($this->notification->getMessage());
    }


    /**
     * Xóa một Khách sạn.
     *
     * @param int $tour_id
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $tour_id, int $id): JsonResponse
    {
        try {
            $this->room->remove($id);
            $this->notification->setMessage('Xóa Khách sạn thành công', Notification::SUCCESS);
        } catch (Exception $e) {
            $this->notification->setMessage('Xóa Khách sạn không thành công', Notification::ERROR);
        }

        return response()->json($this->notification->getMessage());
    }

    /**
     * Xử lý yêu cầu DataTables qua AJAX.
     *
     * @param Request $request
     * @param int $tour_id
     * @return JsonResponse|null
     * @throws Exception
     */
    public function getData(Request $request, int $tour_id): ?JsonResponse
    {
        if ($request->ajax()) {
            return $this->room->getList($tour_id);
        }

        return null;
    }

    /**
     * Lấy danh sách Khách sạn theo tour.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function getRoomByTourId(Request $request): JsonResponse
    {
        $rooms = Room::where('tour_id', $request->tour_id)->get();

        $data = $rooms->map(function ($room) {
            return [
                'id' => $room->id,
                'name' => $room->name . ' - ' . number_format($room->price) . 'đ',
            ];
        });

        return response()->json(['rooms' => $data]);
    }

    /**
     * Lấy dữ liệu biểu đồ về Khách sạn (Khách sạn thuê và Khách sạn trống).
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function getChartData(Request $request): JsonResponse
    {
        $arrDates = Utilities::dateRange($request->startDate, $request->endDate);
        $tour = Tour::find($request->tour_id);

        if (!$tour) {
            return response()->json(['error' => 'Tour không tồn tại'], 404);
        }

        $arrRented = [];
        $arrAvailable = [];
        foreach ($arrDates as $date) {
            $result = $this->checkRoom($tour, $date);

            if ($request->room_id == 0) {
                $arrRented[] = array_sum($result['rented']);
                $arrAvailable[] = array_sum($result['available']);
            } else {
                $arrRented[] = $result['rented'][$request->room_id] ?? 0;
                $arrAvailable[] = $result['available'][$request->room_id] ?? 0;
            }
        }

        return response()->json([
            'room' => [
                'date' => $arrDates,
                'rented' => $arrRented,
                'available' => $arrAvailable,
            ]
        ]);
    }

    /**
     * Kiểm tra phòng trống và phòng đã thuê theo ngày.
     *
     * @param Tour $tour
     * @param string $date
     * @return array
     */
    public function checkRoom(Tour $tour, string $date): array
    {
        $offsetDate = ($tour->duration - 1) * -1;
        $startDate = Carbon::parse($date)->addDays($offsetDate);
        $endDate = Carbon::parse($date);
        $bookings = Booking::where('status', '!=', BOOKING_CANCEL)
            ->with('booking_room')
            ->whereDate('departure_time', '>=', $startDate)
            ->whereDate('departure_time', '<=', $endDate)
            ->where('tour_id', $tour->id)
            ->get();

        $roomRented = [];
        $roomAvailable = [];
        foreach ($tour->rooms as $room) {
            $roomAvailable[$room->id] = $room->number;
            $roomRented[$room->id] = 0;
        }

        foreach ($bookings as $booking) {
            foreach ($booking->booking_room as $bookingRoom) {
                $roomAvailable[$bookingRoom->room_id] -= $bookingRoom->number;
                $roomRented[$bookingRoom->room_id] += $bookingRoom->number;
                if ($roomAvailable[$bookingRoom->room_id] < 0) {
                    $roomAvailable[$bookingRoom->room_id] = 0;
                }
            }
        }

        return [
            'available' => $roomAvailable,
            'rented' => $roomRented,
        ];
    }
    public function order(int $id)
    {
        $hottels = DB::table('rooms')->find($id);

        return view('hottel_booking', compact('hottels'));
    }

    public function bookRoom(Request $request): JsonResponse
    {
        $validatedData = $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'number' => 'required|integer|min:1',
            'customer_name' => 'required|string|max:255',
            'contact_info' => 'required|string|max:255',
            'check_in' => 'required|date|after_or_equal:today',
            'check_out' => 'required|date|after:check_in',
        ]);

        try {
            $room = Room::findOrFail($validatedData['room_id']);

            // Kiểm tra xem có đủ phòng không
            if ($room->number < $validatedData['number']) {
                return response()->json(['message' => 'Không đủ phòng trống'], 400);
            }

            // Tạo một booking mới
            Booking::create([
                'room_id' => $validatedData['room_id'],
                'number' => $validatedData['number'],
                'customer_name' => $validatedData['customer_name'],
                'contact_info' => $validatedData['contact_info'],
                'check_in' => $validatedData['check_in'],
                'check_out' => $validatedData['check_out'],
            ]);

            return response()->json(['message' => 'Đặt phòng thành công'], 200);
        } catch (Exception $e) {
            return response()->json(['message' => 'Có lỗi xảy ra trong quá trình đặt phòng'], 500);
        }
    }
    public function getAvailableRoomsCount()
    {
        // Logic để lấy số lượng phòng còn lại
        return $this->number - Booking::where('room_id', $this->id)
            ->where('status', 'confirmed')
            ->where(function ($query) {
                $query->whereBetween('check_in', [$this->check_in, $this->check_out])
                    ->orWhereBetween('check_out', [$this->check_in, $this->check_out]);
            })->count();
    }
}
