<?php

namespace App\Observers;

use App\Models\TourneyList;
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
        $winner          = $tourneyMatch->getAttribute('winner');
        $player1scoreOld = $tourneyMatch->getAttribute('player1_score');
        $player2scoreOld = $tourneyMatch->getAttribute('player2_score');

        if ( ! empty($winner)) {
            if ($winner == 'player1') {
                if (empty($tourneyMatch->getAttribute('player1_score'))) {
                    $tourneyMatch->setAttribute('player1_score', $score);
                    $tourneyMatch->setAttribute('player2_score', 0);
                }
            } else {
                if (empty($tourneyMatch->getAttribute('player2_score'))) {
                    $tourneyMatch->setAttribute('player1_score', 0);
                    $tourneyMatch->setAttribute('player2_score', $score);
                }
            }
        }
        $player1scoreNew = $tourneyMatch->getAttribute('player1_score');
        $player2scoreNew = $tourneyMatch->getAttribute('player2_score');
        /**
         * Simple enumeration of options have 6 variation for accrual victory & defeat points
         */
        if ( ! empty($tourneyMatch->getAttributeValue('player1_id')) && ! empty($tourneyMatch->getAttributeValue('player2_id'))) {
            if ($player1scoreOld === 0 && $player2scoreOld === 0 && $player1scoreNew === 0 && $player2scoreNew === 2) {
                if ($tourneyMatch->tourney->type == TourneyList::TYPE_DOUBLE) {
                    $tourneyMatch->player1()->increment('defeat');
                }
                $tourneyMatch->player2()->increment('victory_points');
            } elseif ($player1scoreOld === 0 && $player2scoreOld === 2 && $player1scoreNew === 0 && $player2scoreNew === 2) {
                null;
            } elseif ($player1scoreOld === 0 && $player2scoreOld === 0 && $player1scoreNew === 2 && $player2scoreNew === 0) {
                if ($tourneyMatch->tourney->type == TourneyList::TYPE_DOUBLE) {
                    $tourneyMatch->player2()->increment('defeat');
                }
                $tourneyMatch->player1()->increment('victory_points');
            } elseif ($player1scoreOld === 2 && $player2scoreOld === 0 && $player1scoreNew === 2 && $player2scoreNew === 0) {
                null;
            } elseif ($player1scoreOld === 2 && $player2scoreOld === 0 && $player1scoreNew === 0 && $player2scoreNew === 2) {
                /**
                 * 5
                 */
                if ($tourneyMatch->tourney->type == TourneyList::TYPE_DOUBLE) {
                    $tourneyMatch->player1()->increment('defeat');
                    if (($tourneyMatch->player2()->value('defeat') - 1) >= 0) {
                        $tourneyMatch->player2()->decrement('defeat');
                    }
                }
                $tourneyMatch->player2()->increment('victory_points');
                if (($tourneyMatch->player1()->value('victory_points') - 1) >= 0) {
                    $tourneyMatch->player1()->decrement('victory_points');
                }
            } elseif ($player1scoreOld === 0 && $player2scoreOld === 2 && $player1scoreNew === 2 && $player2scoreNew === 0) {
                /**
                 * 6
                 */
                if ($tourneyMatch->tourney->type == TourneyList::TYPE_DOUBLE) {
                    $tourneyMatch->player2()->increment('defeat');
                    if (($tourneyMatch->player1()->value('defeat') - 1) >= 0) {
                        $tourneyMatch->player1()->decrement('defeat');
                    }
                }
                $tourneyMatch->player1()->increment('victory_points');
                if (($tourneyMatch->player2()->value('victory_points') - 1) >= 0) {
                    $tourneyMatch->player2()->decrement('victory_points');
                }
            }
        }

        $tourneyMatch->setAttribute('winner_score', $score);

        unset($tourneyMatch['winner']);
    }

}
