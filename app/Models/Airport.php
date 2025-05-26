<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Airport extends Model
{
    use HasFactory;

    public function city()
    {
        return $this->hasOne(City::class,"city_code","reference_city_code");
    }

    public function Country()
    {
        return $this->hasOne(Country::class,"country_code","country_code");
    }
  
  
}
