<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FlightBookingTravelsInfo extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $dates = ['date_of_birth','passport_expire_date'];


    public function passportIssuedCountry(){

        return $this->belongsTo(Country::class , 'passport_issued_country_id' , 'id');
    }

    public function bookingDetails()
    {
        return $this->belongsTo(FlightBooking::class , 'flight_booking_id' , 'id'); 
    }
}
