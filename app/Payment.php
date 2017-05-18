<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
   protected $fillable = [
        'booking_id', 
        'amount', 
        'transaction_id', 
        'auth_code', 
        'status', 
        'description', 
    ];
}
