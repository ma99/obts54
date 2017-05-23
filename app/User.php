<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

use App\Role;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'phone',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function isNormalUser()
    {
        
        $user = auth()->user(); // authenticated user's object        
        return ( $user->roles->count() == 0 ) ? true : false;
        
        // return !(auth()->user()->roles->contains('name', 'admin') || auth()->user()->roles->contains('name', 'staff') || auth()->user()->roles->contains('name', 'guest')) ? true : false;
        
    }

    public function isAdministrator()
    {         
        return auth()->user()->roles->contains('name', 'admin');
    }

    public function bookings()
    {
        //return $this->hasMany('Booking');
        return $this->hasMany(Booking::class);
    }

    public function roles()
    {
        return $this->hasMany(Role::class);
    }

    // public function setPasswordAttribute($value)
    // {
    //     $this->attributes['password'] = bcrypt($value);
    // }


}
