<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HotelMarkUp extends Model
{
    use HasFactory;

    public function masteragents()
    {
       return $this->hasOne(User::class, 'agency_id', 'id')
        ->where('is_master_agent', 1);
    }
}
