<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RoleLog extends Model
{
	protected $fillable = [
        'name', 'role_id', 'user_id', 'action', 'by'
    ];
    
    public function role()
    {
        return $this->belongsTo(Role::class);
    }
        
}
