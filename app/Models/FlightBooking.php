<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FlightBooking extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function User()
    {
        return $this->belongsTo(User::class);
    }

    public function TravelersInfo()
    {
        return $this->hasMany(FlightBookingTravelsInfo::class);
    }

    public function Customercountry()
    {
        return $this->belongsTo(Country::class, 'country_id','id');
    }

    public function fromAirport()
    {
        return $this->belongsTo(Airport::class,'from','airport_code');
    }

    public function toAirport()
    {
        return $this->belongsTo(Airport::class,'to','airport_code');
    }

    public function AirlinePnr()
    {
        return $this->hasMany(AirlinesPnr::class,'booking_id','id'); 
    }


    public function searchRequest(){

        return $this->belongsTo(FlightBookingSearch::class,'search_id','id');
    }


}
