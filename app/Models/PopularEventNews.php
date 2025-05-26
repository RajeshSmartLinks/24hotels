<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PopularEventNews extends Model
{
    use HasFactory;


    public static $imagePath = 'uploads' . DIRECTORY_SEPARATOR . 'popular_events_news' . DIRECTORY_SEPARATOR;
    public static $imageThumbPath = 'uploads' . DIRECTORY_SEPARATOR . 'popular_events_news' . DIRECTORY_SEPARATOR . 'thumb' . DIRECTORY_SEPARATOR;
    public static $imageUrl = 'uploads/popular_events_news/';
    public static $imageThumbUrl = 'uploads/popular_events_news/thumb/';

    protected $guarded = [];

}
