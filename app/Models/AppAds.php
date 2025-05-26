<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppAds extends Model
{
    use HasFactory;

    public static $imagePath = 'uploads' . DIRECTORY_SEPARATOR . 'ads' . DIRECTORY_SEPARATOR;
    // public static $imageThumbPath = 'uploads' . DIRECTORY_SEPARATOR . 'offers' . DIRECTORY_SEPARATOR . 'thumb' . DIRECTORY_SEPARATOR;
    public static $imageUrl = 'uploads/ads/';
    
    protected $guarded = [];
}
