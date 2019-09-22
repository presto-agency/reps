<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Race extends Model
{
    protected $fillable = [
        'title', 'code',
    ];

    public function raceToUser()
    {
        return $this->belongsTo('App\User');
    }
    public function raceToUsers()
    {
        return $this->hasMany('App\User');
    }
}
