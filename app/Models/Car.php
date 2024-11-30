<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    use HasFactory;

    // Tên bảng trong cơ sở dữ liệu
    protected $table = 'cars';

    // Các cột có thể được fill bằng cách sử dụng hàm create hoặc update
    protected $fillable = [
        'name',
        'brand',
        'license_plate',
        'type',
        'seats',
        'price_per_day',
        'is_available',
        'image',
    ];

    // Các cột cần cast về kiểu dữ liệu cụ thể
    protected $casts = [
        'price_per_day' => 'decimal:2',
        'is_available' => 'boolean',
    ];

    /**
     * Thiết lập quan hệ với bảng 'tours'.
     * Một Car có thể thuộc về một Tour (nhiều xe có thể thuộc về một tour).
     */
    public function tour()
    {
        return $this->belongsTo(Tour::class, 'tour_id');
    }

}
