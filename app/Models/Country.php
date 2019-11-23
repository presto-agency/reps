<?php

namespace App\Models;

use App\User;
use File;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{

    protected $fillable
        = [
            'name', 'code', 'flag',
        ];

    public function using()
    {
        return $this->hasMany(User::class, 'country_id');
    }

    /*$user->avatar*/
    public function getFlagAttribute($value)
    {
        if ( ! empty($value) && File::exists($value)) {
            return $value;
        } else {
            return 'images/default/flag/country.png';
        }
    }

}
