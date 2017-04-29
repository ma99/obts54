<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class GuestUser extends Model
{
	use Notifiable;
	protected $fillable = [
        'name', 'email', 'phone','booking_id','schedule_id', 'seats', 'amount', 'date', 'pickup_point', 'dropping_point',
    ];

    public function seats()
    {
    	return $this->hasMany(Seat::class);
    	//return $this->belongsTo('Schedule'); don't work this way :(
    }

}
