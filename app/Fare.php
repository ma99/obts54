<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Fare extends Model
{
   protected $fillable = [
        'route_id',         
        'details',        
    ];
    
    public function setDetailsAttribute($value)
    {
        $this->attributes['details'] = serialize($value);
    }

    public function getDetailsAttribute($value)
    {   
        return unserialize($value);
    }
}
