<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Booking;

class Schedule extends Model
{
    protected $fillable = [
        'departure_time', 'arrival_time', 'bus_id', 'rout_id'
    ];
    public function bookings()
    {
    	//return $this->hasMany('Booking');
    	return $this->hasMany(Booking::class);
    }
}
