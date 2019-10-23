<?php

namespace App\Traits;

use Illuminate\Support\Str;
use Illuminate\Http\Request;

trait GravatarTrait
{

  public function getAvatarUrlOrBlankAttribute() {
//    if (empty($url = $this->avatar)) {
////      $s = 200;
////      $d = '404';
////      $url = 'https://www.gravatar.com/avatar/';
////      $url .= md5(strtolower(trim($this->email)));
////      $url .= "?s=$s&d=$d";
////
////      if (!@fopen($url,'r')) {
////        $url = '/images/avatar.jpg';
////      }
//
//    }
      $url = 'images/avatar.jpg';
    return $url;
  }
}
