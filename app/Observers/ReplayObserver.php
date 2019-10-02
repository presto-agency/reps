<?php

namespace App\Observers;


use App\Events\UserUploadReplay;
use App\Models\Replay;

class ReplayObserver
{

    public function creating(Replay $replay)
    {

    }

    /**
     * @param Replay $replay
     */
    public function created(Replay $replay)
    {
        event(new UserUploadReplay($replay));
    }


    public function updated(Replay $replay)
    {

    }


    public function deleted(Replay $replay)
    {
        //
    }


    public function restored(Replay $replay)
    {
        //
    }


    public function forceDeleted(Replay $replay)
    {
        //
    }
}
