<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WalletLogger extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function FlightBooking(){
        return $this->belongsTo(FlightBooking::class,'flight_booking_id');
    }
}
