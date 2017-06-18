<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    //
    //protected $table = 'status';
    protected $fillable = [
        'name'
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function role_logs()
    {
        return $this->hasMany(RoleLog::class);
    }
}
