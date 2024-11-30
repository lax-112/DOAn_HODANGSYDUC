<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FlightTickets;
use App\Models\Booking_flight_ticket;
use Illuminate\Http\Request;

class FlightTicketsController extends Controller
{
    // Hiển thị danh sách vé máy bay
    public function index()
    {
        $flightTickets = FlightTickets::all(); // Lấy tất cả vé máy bay
        return view('admin.flight_tickets.index', compact('flightTickets'));
    }

    // Hiển thị form để tạo vé máy bay mới
    public function create()
    {
        return view('admin.flight_tickets.create');
    }

    // Lưu vé máy bay mới
    public function store(Request $request)
    {
        $request->validate([
            'flight_number' => 'required|string|max:255',
            'airline' => 'required|string|max:255',
            'departure_city' => 'required|string|max:255',
            'arrival_city' => 'required|string|max:255',
            'departure_time' => 'required|date',
            'arrival_time' => 'required|date',
            'price' => 'required|numeric',
            'available_seats' => 'required|integer',
        ]);

        // Tạo vé máy bay mới
        FlightTickets::create($request->all());

        return redirect()->route('flight_tickets.index')
                         ->with('success', 'Vé máy bay đã được tạo thành công.');
    }

    // Hiển thị form để sửa vé máy bay
    public function edit($id)
    {
        $flightTicket = FlightTickets::findOrFail($id); // Tìm vé máy bay theo ID
        return view('admin.flight_tickets.edit', compact('flightTicket'));
    }

    // Cập nhật vé máy bay
    public function update(Request $request, $id)
    {
        $request->validate([
            'flight_number' => 'required|string',
            'airline' => 'required|string',
            'departure_city' => 'required|string',
            'arrival_city' => 'required|string',
            'departure_time' => 'required|date',
            'arrival_time' => 'required|date',
            'price' => 'required|numeric',
            'available_seats' => 'required|integer',
        ]);

        $flightTicket = FlightTickets::findOrFail($id);
        $flightTicket->update($request->all());

        return redirect()->route('flight_tickets.index')
                         ->with('success', 'Cập nhật vé máy bay thành công.');
    }

    // Xóa vé máy bay
    public function destroy(FlightTickets $flightTicket)
    {
        $flightTicket->delete();

        return redirect()->route('flight_tickets.index')
                         ->with('success', 'Vé máy bay đã được xóa thành công.');
    }
    // Hiển thị form đặt vé
    public function book($id)
    {
        $ticket = FlightTickets::findOrFail($id); // Tìm vé theo ID
        return view('booking_flight_ticket', compact('ticket')); // Trả về view book với thông tin vé
    }

    // Xử lý lưu thông tin đặt vé
    public function storeBooking(Request $request, $id)
    {
        $request->validate([
            'user_name' => 'required|string|max:255',
            'phone' => 'required|string|max:15',
            'email' => 'required|email|max:255',
            'num_of_passengers' => 'required|integer|min:1',
        ]);
    
        // Tìm vé theo ID
        $ticket = FlightTickets::findOrFail($id);
    
        // Kiểm tra nếu số lượng hành khách đặt lớn hơn số ghế còn lại
        if ($request->num_of_passengers > $ticket->available_seats) {
            return redirect()->back()->withErrors(['Số lượng hành khách không được lớn hơn số ghế còn lại.']);
        }
    
        // Tạo đơn đặt vé mới
        $booking = new Booking_flight_ticket();
        $booking->flight_ticket_id = $ticket->id;
        $booking->user_name = $request->input('user_name');
        $booking->phone = $request->input('phone');
        $booking->email = $request->input('email');
        $booking->num_of_passengers = $request->input('num_of_passengers');
    
        // Kiểm tra xem người dùng có chọn vé khứ hồi hay không
        $return_ticket = $request->has('return_ticket');
    
        // Tổng tiền = giá vé * số lượng hành khách
        // Nếu có vé khứ hồi, tổng tiền sẽ nhân đôi
        $booking->total_price = $ticket->price * $booking->num_of_passengers * ($return_ticket ? 2 : 1);
    
        // Lưu đơn đặt vé vào cơ sở dữ liệu
        $booking->save();
    
        // Trừ số ghế đã đặt từ tổng số ghế khả dụng
        $ticket->available_seats -= $booking->num_of_passengers;
    
        // Cập nhật số ghế khả dụng
        $ticket->save();
    
        return redirect()->route('flight-tickets.book', $ticket->id)
                        ->with('success', 'Đặt vé thành công!');
    }
    public function showBookedFlights()
    {
        // Lấy tất cả vé máy bay đã đặt
        $bookedFlights = Booking_flight_ticket::with('flightTicket')->get(); // Giả định có mối quan hệ giữa Booking_flight_ticket và FlightTickets
    
        return view('admin.flight_tickets.booking_flight_ticket', compact('bookedFlights'));
    }

}
