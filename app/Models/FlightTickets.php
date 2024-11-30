<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FlightTickets extends Model
{
    use HasFactory;

    // Đặt tên bảng nếu khác với mặc định (plural hóa tên model)
    protected $table = 'flight_tickets'; // Nếu bạn đã có bảng này

    // Các thuộc tính có thể được gán hàng loạt
    protected $fillable = [
        'flight_number',
        'airline',
        'departure_city',
        'arrival_city',
        'departure_time',
        'arrival_time',
        'price',
        'available_seats',
        'tour_id', // Nếu có liên kết với tour
    ];

    // Nếu bạn muốn định nghĩa quan hệ với mô hình Tour
    public function tour()
    {
        return $this->belongsTo(Tour::class, 'tour_id'); // Thay đổi nếu tên khóa ngoại khác
    }
}
