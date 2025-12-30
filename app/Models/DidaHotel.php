<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DidaHotel extends Model
{
    use HasFactory;
    protected $fillable = [
        'hotel_id',
        'language',
        'name',
        'country_code',
        'country_name',
        'destination_code',
        'destination_name',
        'longitude',
        'latitude',
        'state_code',
        'address',
        'telephone',
        'star_rating',
        'zip_code',
        'images',
        'thumbnail'
    ];
}
