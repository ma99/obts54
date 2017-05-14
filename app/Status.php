<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    //
    //protected $table = 'status';
    protected $fillable = [
        'role'
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
