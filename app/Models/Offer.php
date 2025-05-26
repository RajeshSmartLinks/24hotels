<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    use HasFactory;


    public static $imagePath = 'uploads' . DIRECTORY_SEPARATOR . 'offers' . DIRECTORY_SEPARATOR;
    public static $imageThumbPath = 'uploads' . DIRECTORY_SEPARATOR . 'offers' . DIRECTORY_SEPARATOR . 'thumb' . DIRECTORY_SEPARATOR;
    public static $imageUrl = 'uploads/offers/';
    public static $imageThumbUrl = 'uploads/offers/thumb/';

    protected $guarded = [];

    // public function getImageAttribute($value)
    // {
    //     return env('APP_URL'). 'uploads/offers/' . $value;
    // }

    
}
