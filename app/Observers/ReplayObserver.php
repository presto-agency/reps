<?php

namespace App\Observers;

use App\Models\Replay;

class ReplayObserver
{
    /**
     * @param Replay $replay
     */
    public function creating(Replay $replay)
    {

    }

    /**
     * @param Replay $replay
     */
    public function created(Replay $replay)
    {

    }

    /**
     * Handle the replay "updated" event.
     *
     * @param  \App\Models\Replay  $replay
     * @return void
     */
    public function updated(Replay $replay)
    {

    }

    /**
     * Handle the replay "deleted" event.
     *
     * @param  \App\Models\Replay  $replay
     * @return void
     */
    public function deleted(Replay $replay)
    {
        //
    }

    /**
     * Handle the replay "restored" event.
     *
     * @param  \App\Models\Replay  $replay
     * @return void
     */
    public function restored(Replay $replay)
    {
        //
    }

    /**
     * Handle the replay "force deleted" event.
     *
     * @param  \App\Models\Replay  $replay
     * @return void
     */
    public function forceDeleted(Replay $replay)
    {
        //
    }
}
