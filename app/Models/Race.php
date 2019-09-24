<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Race extends Model
{
    protected $fillable = [
        'title', 'code',
    ];

    public function users()
    {
        return $this->hasMany(\App\User::class, 'race_id', 'id');
    }
    public function streams()
    {
        return $this->hasMany(\App\Models\Stream::class, 'race_id', 'id');
    }
}
