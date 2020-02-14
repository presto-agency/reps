<?php

namespace App\Traits\ModelRelations;


use App\Models\TourneyListsMapPool;
use App\Models\TourneyMatch;
use App\Models\TourneyPlayer;
use App\User;


trait TournamentRelationTrait
{

    /**
     * @return mixed
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * @return mixed
     */
    public function players()
    {
        return $this->hasMany(TourneyPlayer::class, 'tourney_id', 'id');
    }

    /**
     * @return mixed
     */
    public function playersNew()
    {
        return $this->hasMany(TourneyPlayer::class, 'tourney_id', 'id');
    }

    /**
     * @return mixed
     */
    public function player()
    {
        return $this->hasOne(TourneyPlayer::class, 'tourney_id', 'id');
    }

    /**
     * @return mixed
     */
    public function mapsPool()
    {
        return $this->hasMany(TourneyListsMapPool::class, 'tourney_id', 'id');
    }

    /**
     * @return mixed
     */
    public function matches()
    {
        return $this->hasMany(TourneyMatch::class, 'tourney_id', 'id');
    }

    /**
     *
     * @return mixed
     */
    public function checkPlayers()
    {
        return $this->hasMany(TourneyPlayer::class, 'tourney_id', 'id')->whereBan(false)->whereCheck(true);
    }

    /**
     * @return mixed
     */
    public function banPlayers()
    {
        return $this->hasMany(TourneyPlayer::class, 'tourney_id', 'id')->whereBan(true);
    }

    public function checkDefeat0Players()
    {
        return $this->hasMany(TourneyPlayer::class, 'tourney_id', 'id')->where('check', true)
            ->where('ban', false)
            ->where('defeat', 0);
    }

    public function checkDefeat1Players()
    {
        return $this->hasMany(TourneyPlayer::class, 'tourney_id', 'id')->where('check', true)
            ->where('ban', false)
            ->where('defeat', 1);
    }

    public function checkDefeat2Players()
    {
        return $this->hasMany(TourneyPlayer::class, 'tourney_id', 'id')->where('check', true)
            ->where('ban', false)
            ->where('defeat', '>=', 2);
    }


}
