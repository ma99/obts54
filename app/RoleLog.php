<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RoleLog extends Model
{
	protected $fillable = [
       'user_id', 'action', 'by'
    ];
    
    public function role()
    {
        return $this->belongsTo(User::class);
    }
        
}
