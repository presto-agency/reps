<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{

    protected $fillable
        = [
            'title', 'name',
        ];


    public static function getRoleId($name)
    {

        return Role::where('name', $name)->value('id');

    }

}
