<?php

namespace App\Observers;

use App\Models\TourneyList;
use TourneyService;

class TourneyListObserver
{

    public function creating(TourneyList $tourneyList)
    {
        $tourneyList->setAttribute('status', array_search('ANNOUNCE', TourneyList::$status));
    }

    /**
     * Handle the tourney list "created" event.
     *
     * @param  \App\Models\TourneyList  $tourneyList
     *
     * @return void
     */
    public function created(TourneyList $tourneyList)
    {
        //
    }

    public function updating(TourneyList $tourneyList)
    {
        TourneyService::generateWinnersMatches($tourneyList);
    }

    /**
     * Handle the tourney list "updated" event.
     *
     * @param  \App\Models\TourneyList  $tourneyList
     *
     * @return void
     */
    public function updated(TourneyList $tourneyList)
    {
        //
    }

    /**
     * Handle the tourney list "deleted" event.
     *
     * @param  \App\Models\TourneyList  $tourneyList
     *
     * @return void
     */
    public function deleted(TourneyList $tourneyList)
    {
        //
    }

    /**
     * Handle the tourney list "restored" event.
     *
     * @param  \App\Models\TourneyList  $tourneyList
     *
     * @return void
     */
    public function restored(TourneyList $tourneyList)
    {
        //
    }

    /**
     * Handle the tourney list "force deleted" event.
     *
     * @param  \App\Models\TourneyList  $tourneyList
     *
     * @return void
     */
    public function forceDeleted(TourneyList $tourneyList)
    {
        //
    }

}
