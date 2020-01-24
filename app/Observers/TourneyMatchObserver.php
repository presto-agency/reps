<?php

namespace App\Observers;

use App\Models\TourneyMatch;
use TourneyService;

class TourneyMatchObserver
{


    /**
     * Handle the tourney match "created" event.
     *
     * @param  \App\Models\TourneyMatch  $tourneyMatch
     *
     * @return void
     */
    public function created(TourneyMatch $tourneyMatch)
    {
        //
    }

    /**
     * Handle the tourney match "updated" event.
     *
     * @param  \App\Models\TourneyMatch  $tourneyMatch
     *
     * @return void
     */
    public function updated(TourneyMatch $tourneyMatch)
    {
        //
    }

    /**
     * Handle the tourney match "deleted" event.
     *
     * @param  \App\Models\TourneyMatch  $tourneyMatch
     *
     * @return void
     */
    public function deleted(TourneyMatch $tourneyMatch)
    {
        //
    }

    /**
     * Handle the tourney match "restored" event.
     *
     * @param  \App\Models\TourneyMatch  $tourneyMatch
     *
     * @return void
     */
    public function restored(TourneyMatch $tourneyMatch)
    {
        //
    }

    /**
     * Handle the tourney match "force deleted" event.
     *
     * @param  \App\Models\TourneyMatch  $tourneyMatch
     *
     * @return void
     */
    public function forceDeleted(TourneyMatch $tourneyMatch)
    {
        //
    }

}
