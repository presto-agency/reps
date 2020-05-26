<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MetaTag extends Model
{

    protected $guarded
        = [
            'seo_title',
            'seo_keywords',
            'seo_description',
        ];

}
