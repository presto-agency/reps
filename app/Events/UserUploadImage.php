<?php


namespace App\Events;


use App\Models\UserGallery;
use Illuminate\Queue\SerializesModels;


class UserUploadImage
{

    use SerializesModels;

    public $userGallery;


    public function __construct(UserGallery $userGallery)
    {
        $this->userGallery = $userGallery;
    }

}
