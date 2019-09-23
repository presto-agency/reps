<?php

namespace App\Observers;
use App\Models\UserGallery;

class UserGalleryObservers

{
    private static $data;

    /**
     * @param UserGallery $poll
     */
    public function creating(UserGallery $poll)
    {

    }


    public function created(UserGallery $poll)
    {

    }



    public function updated(UserGallery $poll)
    {
        //
    }


    public function deleted(UserGallery $poll)
    {
        //
    }


    public function restored(UserGallery $poll)
    {
        //
    }


    public function forceDeleted(UserGallery $poll)
    {
        //
    }
}
