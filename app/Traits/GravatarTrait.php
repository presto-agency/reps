<?php

namespace App\Traits;

use Illuminate\Support\Str;
use Illuminate\Http\Request;

trait GravatarTrait
{
    /*$user->avatar*/
    public function getAvatarAttribute($value)
    {
        if (!empty($value) && \File::exists($value)) {
            return asset($value);
        } else {
            return asset('images/default/avatar/avatar.png');
        }
    }
}


