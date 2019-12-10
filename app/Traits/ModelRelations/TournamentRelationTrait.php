<?php

namespace App\Traits\ModelRelations;


use Illuminate\Database\Eloquent\Relations\HasMany;

trait TournamentRelationTrait
{

    /**
     * Relations.
     *
     * @return HasMany
     */

    public function matches()
    {
        return $this->hasMany('App\Models\TourneyMatch', 'tourney_id', 'id');
    }

    public function players()
    {
        return $this->hasMany('App\Models\TourneyPlayer', 'tourney_id', 'id');
    }

    public function admin_user()
    {
        return $this->belongsTo('App\User', 'admin_id');
    }

    public function checkin_players()
    {
        return $this->hasMany('App\Models\TourneyPlayer', 'tourney_id', 'id')
            ->where('check_in', 1);
    }

    public function win_player()
    {
        return $this->hasMany('App\Models\TourneyPlayer', 'tourney_id', 'id')
            ->where('place_result', 1);
    }

}
