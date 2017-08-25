<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rout extends Model
{
    protected $fillable = [
        'departure_city', 'arrival_city', 'distance'
    ];

    public function fare()
    {
        return $this->hasOne(Fare::class);
    }
}
