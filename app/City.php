<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    //public $incrementing = false; 
    protected $fillable = [
        'code', 'name', 'division'
    ];
}
