<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PendingHotelRoomBooking extends Model
{
    use HasFactory;

    protected $table = 'pending_hotel_room_bookings';

    protected $fillable = [
        'booking_id',
        'cron_status',
        'status',
        'time',
    ];

    protected $casts = [
        'time' => 'datetime',
    ];
}
