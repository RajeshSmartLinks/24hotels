<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GtsHotel extends Model
{
    use HasFactory;

    protected $table = 'gts_hotels';

    protected $fillable = [
        'hotel_id',
        'country_code',
        'country_name',
        'longitude',
        'latitude',
        'name',
        'star_rating',
        'address',
        'telephone',
        'zipcode',
        'thumbnail',
        'checkin',
        'checkout',
        'rooms',
        'city_code'
    ];
}
