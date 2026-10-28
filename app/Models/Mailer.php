<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mailer extends Model
{
    use HasFactory;

    protected $table = 'mailers';

    protected $guarded = [];

    /**
     * Scope query for pending unsent emails.
     */
    public function scopePending($query)
    {
        return $query->where('is_send', '0');
    }

    public function getRecipientNameAttribute()
    {
        return $this->receiver_name;
    }

    public function setRecipientNameAttribute($value)
    {
        $this->attributes['receiver_name'] = $value;
    }

    public function getSentDateTimeAttribute()
    {
        return $this->sent_at;
    }

    public function setSentDateTimeAttribute($value)
    {
        $this->attributes['sent_at'] = $value;
    }
}
