<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GtsHotelList extends Model
{
    use HasFactory;

    protected $table = 'gts_hotel_lists';

    protected $fillable = [
        'hotel_id',
        'is_hotel_details_dumped',
    ];
}
