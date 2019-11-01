<?php

namespace App\Traits;

use Illuminate\Support\Str;
use Illuminate\Http\Request;

trait GravatarTrait
{
    /*$user->avatar*/
    public function getAvatarAttribute($value)
    {
        if ($value) {
            return asset($value);
        } else {
            return asset('images/newsAvatar.png');
        }
    }

    /*$user->avatar_url_or_blank*/
//    public function getAvatarUrlOrBlankAttribute()
//    {
//        if (empty($url = $this->avatar)) {
//            $s = 200;
//            $d = '404';
//            $url = 'https://www.gravatar.com/avatar/';
//            $url .= md5(strtolower(trim($this->email)));
//            $url .= "?s=$s&d=$d";
//            if (!@fopen($url, 'r')) {
//                $url = '/images/avatar.jpg';
//            }
//        }
//    }
}


