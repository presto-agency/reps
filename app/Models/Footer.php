<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Footer extends Model
{
    protected $fillable = [
        'title',
        'position',
        'text',
        'email',
        'icq',
        'approved'
    ];
}
