<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MetaTag extends Model
{

    protected $guarded
        = [
            'title',
            'description',
        ];

}
