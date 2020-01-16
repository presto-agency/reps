<?php

namespace App\Observers;


use App\Events\UserUploadReplay;
use App\Models\Replay;

class ReplayObserver
{

    public function creating(Replay $replay)
    {
        /**
         * User role cannot add PRO-Replay
         */
        if (auth()->user()->roles->name === 'user') {
            $replay->setAttribute('user_replay', \App\Models\Replay::REPLAY_USER);
        }
        $replay->setAttribute('user_id', auth()->id());
    }

    /**
     * @param  Replay  $replay
     */
    public function created(Replay $replay)
    {
        event(new UserUploadReplay($replay));
    }


    public function updating(Replay $replay)
    {
//        $replay->setAttribute('user_id', auth()->id());
    }

    public function updated(Replay $replay)
    {
        //

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
