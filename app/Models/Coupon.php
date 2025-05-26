<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;

    protected $fillable = [
        'coupon_title',
        'coupon_code',
        'coupon_type',
        'coupon_amount',
        'coupon_valid_from',
        'coupon_valid_to',
        'coupon_valid_for',
        'coupon_valid_on',
        'status',
        // Add other fields as needed
    ];
}
