<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Booking_flight_ticket extends Model
{
    use HasFactory;

    protected $table = 'booking_flight_ticket';

    protected $fillable = [
        'flight_ticket_id',
        'user_name',
        'phone',
        'email',
        'num_of_passengers',
        'total_price',
    ];

    // Định nghĩa mối quan hệ với vé máy bay
    public function flightTicket()
    {
        return $this->belongsTo(FlightTickets::class, 'flight_ticket_id');
    }
}