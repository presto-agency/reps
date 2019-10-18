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
        return $this->hasMany(\App\User::class,'country_id');
    }
}
