<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bus extends Model
{
    protected $fillable = [
        'reg_no',
        'number_plate',
		'type',
		'total_seats',
		'description',
		'seatplan_done'
   	];
}
