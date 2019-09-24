<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $fillable = [
        'title', 'name'
    ];

    public function users()
    {
        return $this->hasMany(\App\User::class, 'role_id', 'id');
    }
}
