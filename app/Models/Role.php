<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $fillable = [
        'title', 'name'
    ];

    public function roleToUser()
    {
        return $this->belongsTo('App\User');
    }

    public function roleToUsers()
    {
        return $this->hasMany('App\User');
    }
}
