<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    protected $fillable = [
        'name', 'code', 'flag'
    ];

    public function using()
    {
        return $this->hasMany(\App\User::class, 'country_id');
    }

    /*$user->avatar*/
    public function getFlagAttribute($value)
    {
        if ($value) {
            return asset($value);
        } else {
            return asset('images/default/flag/country.png');
        }
    }
}
