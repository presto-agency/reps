<?php

namespace App\Observers;

use App\Events\UserUploadImage;
use App\Models\UserGallery;

class UserGalleryObservers

{

    public function creating(UserGallery $userGallery)
    {

        $this->setUserIdAttribute($userGallery);

    }

    /**
     * @param UserGallery $userGallery
     */
    public function created(UserGallery $userGallery)
    {

        event(new UserUploadImage($userGallery));
    }


    public function updating(UserGallery $userGallery)
    {
        $this->setUserIdAttribute($userGallery);
    }

    public function updated(UserGallery $userGallery)
    {
        //
    }


    public function deleted(UserGallery $userGallery)
    {
        //
    }


    public function restored(UserGallery $userGallery)
    {
        //
    }


    public function forceDeleted(UserGallery $userGallery)
    {
        //
    }

    private function setUserIdAttribute($data)
    {
        return $data['user_id'] = auth()->user()->id;

    }
}
