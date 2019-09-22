<?php

namespace App\Observers;

use App\Models\Poll;

class PollObserver
{


    /**
     * То что поступает в модель ещё не созданно
     * @param Poll $poll
     */
    public function creating(Poll $poll)
    {

    }

    /**
     * Handle the poll "created" event.
     * То что уже созданно в базе данных
     * @param \App\Poll $poll
     * @return void
     */
    public function created(Poll $poll)
    {

    }


    /**
     * Handle the poll "updated" event.
     *
     * @param \App\Poll $poll
     * @return void
     */
    public function updated(Poll $poll)
    {
        //
    }

    /**
     * Handle the poll "deleted" event.
     *
     * @param \App\Poll $poll
     * @return void
     */
    public function deleted(Poll $poll)
    {
        //
    }

    /**
     * Handle the poll "restored" event.
     *
     * @param \App\Poll $poll
     * @return void
     */
    public function restored(Poll $poll)
    {
        //
    }

    /**
     * Handle the poll "force deleted" event.
     *
     * @param \App\Poll $poll
     * @return void
     */
    public function forceDeleted(Poll $poll)
    {
        //
    }
}
