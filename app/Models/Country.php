<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    protected $fillable = [
        'name', 'code', 'flag'
    ];

    public function countryToUser()
    {
        return $this->belongsTo('App\User');
    }

    public function countryToUsers()
    {
        return $this->hasMany('App\User');
    }
}
