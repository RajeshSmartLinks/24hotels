<?php

namespace App\Models;

use App\Models\User;
use App\Models\Country;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Agency extends Model
{
    public static $imagePath = 'uploads' . DIRECTORY_SEPARATOR . 'agency' . DIRECTORY_SEPARATOR;
    public static $imageThumbPath = 'uploads' . DIRECTORY_SEPARATOR . 'agency' . DIRECTORY_SEPARATOR . 'thumb' . DIRECTORY_SEPARATOR;
    public static $imageUrl = 'uploads/agency/';
    public static $imageThumbUrl = 'uploads/agency/thumb/';

    protected $guarded = [];

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

   public function masterAgent(): HasOne
    {
        return $this->hasOne(User::class, 'agency_id', 'id')
            ->where('is_master_agent', 1);
    }
}
