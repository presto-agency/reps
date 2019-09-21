<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $fillable = [
        'title', 'name'
    ];

    public function userWithThisRole()
    {
        return $this->belongsTo('App\User')->first();
    }

    public function usersWithThisRole()
    {
        return $this->hasMany('App\User')->get();
    }
}
