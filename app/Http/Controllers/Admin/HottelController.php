<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Hottel_booking;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class HottelController extends Controller
{
    public function order(int $id)
    {
        $hottels = Room::findOrFail($id); // Tìm phòng theo ID

        return view('hottel_booking', compact('hottels'));
    }

    public function index()
    {
        // $bookings = DB::table('hottel_bookings')->get();
        $bookings = Hottel_booking::all();

        return view('admin.hottel.index', compact('bookings'));
    }

    public function store(Request $request)
    {
        // Xác thực dữ liệu
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'contact_info' => 'required|string|max:255',
            'number' => 'required|integer|min:1',
            'check_in' => 'required|date|after_or_equal:today',
            'check_out' => 'required|date|after:check_in',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
//dd($request);
        // Tính tổng số tiền
        $room = Room::findOrFail($request->input('room_id'));
        $checkIn = new \DateTime($request->input('check_in'));
        $checkOut = new \DateTime($request->input('check_out'));
        $days = $checkOut->diff($checkIn)->days;
        $totalPrice = $room->price * $days * $request->input('number');
//dd($room->number - $request->input('number'));
        // Lưu thông tin đặt phòng vào cơ sở dữ liệu
        try {
            DB::table('hettel_bookings')->insert([
                'room_id' => $request->room_id,
                'customer_name' => $request->name,
                'contact_info' => $request->contact_info,
                'number' => $request->number,
                'check_in' => $request->check_in,
                'check_out' => $request->check_out,
                'total_price' => $totalPrice, // Lưu tổng tiền
                'status' => 'booked',
            ]);
            Room::where('id', $room->id)->update([
                'number' => $room->number - $request->input('number'),
            ]);            

            return redirect()->route('hottels.book', ['id' => $request->input('room_id')])->with('success', 'Đặt phòng thành công!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Có lỗi xảy ra, vui lòng thử lại sau.');
        }
    }
}
