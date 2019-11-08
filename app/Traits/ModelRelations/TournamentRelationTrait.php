<?php

namespace App\Traits\ModelRelations;


trait TournamentRelationTrait
{
    /**
     * Relations.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */

    public function matches()
    {
        return $this->hasMany('App\Models\TourneyMatch', 'tourney_id');
    }

    public function players()
    {
        return $this->hasMany('App\Models\TourneyPlayer', 'tourney_id');
    }

    public function admin_user()
    {
        return $this->belongsTo('App\User', 'admin_id');
    }

    public function checkin_players()
    {
        return $this->hasMany('App\Models\TourneyPlayer', 'tourney_id')->where('check_in', 1);
    }

    public function win_player()
    {
        return $this->hasMany('App\Models\TourneyPlayer', 'tourney_id')->where('place_result', 1);
    }

}
