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
        'name', 'email', 'phone',
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
        //$userId = $user->id;
        //role: admin/staff
        //m-1
        /*if ( $user->roles()->role == 'normal') {  
            $userId = $user->id;
        }*/
        //m-2 collect info from roles tble for this user. if no info found means he is normal user.  
        // if ($user->roles->count() < 1) {  
        //     $userId = $user->id;
        // }
        return ( $user->roles->count() == 0 ) ? true : false;
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

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }


}
