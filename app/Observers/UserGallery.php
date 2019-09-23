<?php

namespace App\Observers;

class UserGallery
{
    private static $data;

    /**
     * @param UserGallery $poll
     */
    public function creating(UserGallery $poll)
    {

    }

    /**
     * Handle the poll "created" event.
     * То что уже созданно в базе данных
     * @param \App\UserGalleryl $poll
     * @return void
     */
    public function created(UserGallery $poll)
    {

    }


    /**
     * Handle the poll "updated" event.
     *
     * @param \App\UserGalleryl $poll
     * @return void
     */
    public function updated(UserGallery $poll)
    {
        //
    }

    /**
     * Handle the poll "deleted" event.
     *
     * @param \App\UserGalleryl $poll
     * @return void
     */
    public function deleted(UserGallery $poll)
    {
        //
    }

    /**
     * Handle the poll "restored" event.
     *
     * @param \App\UserGalleryl $poll
     * @return void
     */
    public function restored(UserGallery $poll)
    {
        //
    }

    /**
     * Handle the poll "force deleted" event.
     *
     * @param \App\UserGalleryl $poll
     * @return void
     */
    public function forceDeleted(UserGallery $poll)
    {
        //
    }
}
