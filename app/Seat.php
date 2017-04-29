<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Seat extends Model
{
     protected $fillable = [
        'booking_id', 'seat_no', 'status',
    ];
    public function booking()
    {
    	return $this->belongsTo(Booking::class);
    }

    // public function guest_booking()
    // {
    // 	return $this->belongsTo(GuestUser::class);
    // }
}
