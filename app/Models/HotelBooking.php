<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HotelBooking extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function Customercountry()
    {
        return $this->belongsTo(Country::class, 'country_id','id');
    }

    public function hotelReservation(){
        return $this->hasOne(HotelReservation::class ,'booking_id' , 'id');
    }

    // public function hotelDetails(){
    //     return $this->belongsTo(TboHotel::class ,'hotel_code' , 'hotel_code');
    // }
    public function TravelersInfo()
    {
        return $this->hasMany(HotelBookingTravelsInfo::class);
    }

    public function CouponDetails()
    {
        return $this->belongsTo(Coupon::class, 'coupon_id','id');
    }
    public function confirmations()
    {
        return $this->hasMany(HotelRoomBookingInfo::class, 'hotel_booking_id', 'id'); 
        // Adjust foreign/local key names as needed
    }
    public function User()
    {
        return $this->belongsTo(User::class);
    }
}
