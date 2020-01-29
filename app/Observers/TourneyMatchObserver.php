<?php

namespace App\Observers;

use App\Models\TourneyMatch;

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


    public function updating(TourneyMatch $tourneyMatch)
    {
        $this->checkWinner($tourneyMatch, 2);
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

    /**
     * @param  \App\Models\TourneyMatch  $tourneyMatch
     * @param  int  $score
     */
    private function checkWinner(TourneyMatch $tourneyMatch, int $score)
    {
        $winner = $tourneyMatch->getAttribute('winner');

        if ( ! empty($winner)) {
            if ($winner == 'player1') {
                $tourneyMatch->setAttribute('player1_score', $score);
                $tourneyMatch->setAttribute('player2_score', 0);
            }
            if ($winner == 'player2') {
                $tourneyMatch->setAttribute('player1_score', 0);
                $tourneyMatch->setAttribute('player2_score', $score);
            }
            $tourneyMatch->setAttribute('winner_score', $score);
        }
        unset($tourneyMatch['winner']);
    }

}
