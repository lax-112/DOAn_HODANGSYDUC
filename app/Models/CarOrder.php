<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarOrder extends Model
{
    use HasFactory;

    // Định nghĩa bảng liên kết
    protected $table = 'carorder';

    // Các cột có thể được gán hàng loạt
    protected $fillable = [
        'car_id',        // ID của xe đặt
        'user_name',     // Tên người dùng
        'phone',         // Số điện thoại
        'email',         // Địa chỉ email
        'start_date',    // Ngày bắt đầu đặt xe
        'end_date',      // Ngày kết thúc đặt xe
        'car_name',      // Tên xe
        'car_brand',     // Thương hiệu xe
        'license_plate', // Biển số xe
        'type',          // Loại xe
        'seats',         // Số chỗ ngồi
        'price_per_day', // Giá mỗi ngày
    ];

    // Định nghĩa mối quan hệ với model Car
    public function car()
    {
        return $this->belongsTo(Car::class);
    }
}
