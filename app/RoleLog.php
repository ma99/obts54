<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RoleLog extends Model
{
	protected $fillable = [
        'name', 'action', 'by'
    ];
    
    public function role()
    {
        return $this->belongsTo(Role::class);
    }
        
}
