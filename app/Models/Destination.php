<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Destination extends Model
{
    use HasFactory;
    public static $imagePath = 'uploads' . DIRECTORY_SEPARATOR . 'destinations' . DIRECTORY_SEPARATOR;
    // public static $imageThumbPath = 'uploads' . DIRECTORY_SEPARATOR . 'offers' . DIRECTORY_SEPARATOR . 'thumb' . DIRECTORY_SEPARATOR;
    public static $imageUrl = 'uploads/offers/';
    // public static $imageThumbUrl = 'uploads/offers/thumb/';

    protected $guarded = [];
}
