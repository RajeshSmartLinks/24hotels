<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function scopeNonSmart($query)
    {
        return $query->where('slug', '!=', 'admin');
    }

    public function scopeBackendRoles($query)
    {
        return $query->where('slug', '!=', 'user');
    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class)->withTimestamps();
    }

    public function admins()
    {
        return $this->belongsToMany(User::class);
    }
}
