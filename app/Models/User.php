<?php

namespace App\Models;

use Laravel\Passport\HasApiTokens;
use App\Permissions\HasPermissionsTrait;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory, Notifiable ,HasPermissionsTrait,HasApiTokens;

    public static $imagePath = 'uploads' . DIRECTORY_SEPARATOR . 'users' . DIRECTORY_SEPARATOR;
    public static $imageThumbPath = 'uploads' . DIRECTORY_SEPARATOR . 'users' . DIRECTORY_SEPARATOR . 'thumb' . DIRECTORY_SEPARATOR;
    public static $imageUrl = 'uploads/users/';
    public static $imageThumbUrl = 'uploads/users/thumb/';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'email', 'password','mobile','last_name','back_end_user','profile_pic'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function scopeNonSmartOnly($query)
    {
        return $query->where('id', '!=', '1');
    }

    public function scopeBackEndUsers($query)
    {
        return $query->where('back_end_user', 1);
    }
     
    public function roles()
    {
        return $this->belongsToMany(Role::class)->withTimestamps();
    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class)->withTimestamps();
    }

    // Return the user single role
    public function hisRole()
    {
        foreach ($this->roles as $role) {
            return $role->name;
        }
    }

    public function hasRole($role_slug)
    {
        foreach ($this->roles as $role) {
            if ($role->slug == $role_slug) {
                return true;
            }
        }
        return false;
    }

    public function assignRole($role)
    {
        $this->roles()->attach($role);
    }

    public function Usercountry()
    {
        return $this->belongsTo(Country::class, 'country_id','id');
    }

    public function agentMarkup()
    {
        return $this->hasOne(MarkUp::class);
    }

    public function agentHotelMarkup()
    {
        return $this->hasOne(HotelMarkUp::class);
    }
    public function agency()
    {
        return $this->belongsTo(Agency::class);
    }

}
