<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class GuestUser extends Model
{
	use Notifiable;
    protected $primaryKey = 'phone'; // or null
    public $incrementing = false;
    
	protected $fillable = [
        'name', 'email', 'phone',
    ];

    // public function seats()
    // {
    // 	return $this->hasMany(Seat::class);
    // 	//return $this->belongsTo('Schedule'); don't work this way :(
    // }
     public function bookings()
    {
    	return $this->hasMany(Booking::class);
    	//return $this->belongsTo('Schedule'); don't work this way :(
    }

}
