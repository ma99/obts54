<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SeatPlan extends Model
{
	protected $fillable = [
        'bus_id',         
        'seat_list',        
    ];
    
    public function setSeatListAttribute($value)
    {
        $this->attributes['seat_list'] = serialize($value);
    }

    public function getSeatListAttribute($value)
    {   
        return unserialize($value);
    }
}
