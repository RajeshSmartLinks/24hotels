<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PendingPnrs extends Model
{
    use HasFactory;

    public function flightBooking(){
        return $this->hasOne(FlightBooking::class ,'id' , 'booking_id');
    }

}
