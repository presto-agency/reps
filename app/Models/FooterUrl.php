<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FooterUrl extends Model
{

    protected $fillable
        = [
            'title',
            'url',
            'approved',
        ];

}
