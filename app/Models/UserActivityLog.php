<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserActivityLog extends Model
{
    protected $fillable = [
        'type', 'user_id', 'time', 'ip', 'parameters'
    ];

    public function users()
    {
        return $this->belongsTo(\App\User::class, 'user_id', 'id');
    }
}
