<?php

namespace App\Observers;

use App\Models\Replay;

class ReplayObserver
{
    public function creating(Replay $replay)
    {

    }

    /**
     * Handle the replay "created" event.
     *
     * @param  \App\Models\Replay  $replay
     * @return void
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
        //
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
