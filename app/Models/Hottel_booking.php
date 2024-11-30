<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hottel_booking extends Model
{
    use HasFactory;
    protected $table = 'hettel_bookings';

    protected $fillable = [
        'room_id',
        'number',
        'customer_name',
        'contact_info',
        'check_in',
        'check_out',
        'status',
        'total_price',
    ];

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    // /**
    //  * Lưu thông tin đặt phòng
    //  *
    //  * @param Request $request
    //  * @return Hottel_booking
    //  */
    // public function saveBooking(Request $request): Hottel_booking
    // {
    //     return $this->create([
    //         'room_id' => $request->room_id, // ID phòng đặt
    //         'number' => $request->number, // Số lượng phòng
    //         'customer_name' => $request->name, // Tên khách hàng
    //         'contact_info' => $request->contact_info, // Thông tin liên lạc
    //         'check_in' => $request->check_in, // Ngày nhận phòng
    //         'check_out' => $request->check_out, // Ngày trả phòng
    //         'status' => 'booked', // Trạng thái đặt phòng
    //         'total_price' => $request->total_price, // Tổng tiền
    //     ]);
    // }
}
