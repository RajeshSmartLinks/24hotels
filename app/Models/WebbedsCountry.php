<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WebbedsCountry extends Model
{
    use HasFactory;
     protected $fillable = [
        'dida_city_dumped',
        'dida_hotel_dumped',
        'hotel_list_dumped_on'
    ];
}
