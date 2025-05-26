<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FacebookPost extends Model
{
    protected $table = 'facebook_posts';

    protected $fillable = [
        'image_url',
        'post_id',
        // Add other fillable fields here
    ];
}