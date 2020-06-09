<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Help extends Model
{

    protected $fillable
        = [
            'display_name', 'key', 'value', 'description',
        ];

}
