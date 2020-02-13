<?php

namespace App\Traits\ModelRelations;


use App\Models\TourneyList;
use App\Models\TourneyPlayer;

trait TourneyMatchRelation
{


    public function tourney()
    {
        return $this->belongsTo(TourneyList::class, 'tourney_id', 'id');
    }

    /**
     * @return mixed
     */
    public function player1()
    {
        return $this->belongsTo(TourneyPlayer::class, 'player1_id', 'id');
    }

    /**
     * @return mixed
     */
    public function player2()
    {
        return $this->belongsTo(TourneyPlayer::class, 'player2_id', 'id');
    }


    /**
     * @return mixed
     */
    public function checkPlayers1()
    {
        return $this->belongsTo(TourneyPlayer::class, 'player1_id', 'id')->whereBan(false)->whereCheck(true);
    }

    /**
     * @return mixed
     */
    public function checkPlayers2()
    {
        return $this->belongsTo(TourneyPlayer::class, 'player2_id', 'id')->whereBan(false)->whereCheck(true);
    }

}
