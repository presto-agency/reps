<?php

namespace App\Traits\ModelRelations;


use App\Models\Country;
use App\Models\Race;
use App\Models\ReplayMap;
use App\Models\ReplayType;
use App\Models\UserReputation;
use App\User;

trait ReplayRelationTrait
{

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function maps()
    {
        return $this->belongsTo(ReplayMap::class, 'map_id', 'id');
    }

    public function types()
    {
        return $this->belongsTo(ReplayType::class, 'type_id', 'id');
    }

    public function firstCountries()
    {
        return $this->belongsTo(Country::class, 'first_country_id',
            'id');
    }

    public function secondCountries()
    {
        return $this->belongsTo(Country::class, 'second_country_id',
            'id');
    }


    public function firstRaces()
    {
        return $this->belongsTo(Race::class, 'first_race', 'id');
    }

    public function secondRaces()
    {
        return $this->belongsTo(Race::class, 'second_race', 'id');
    }

    /**
     * Get all of the topic comments.
     */
    public function comments()
    {
        return $this->morphMany('App\Models\Comment', 'commentable');
    }


    /**
     * @return mixed
     */
    public function positive()
    {
        return $this->hasMany('App\Models\UserReputation', 'object_id')
            ->where('relation', UserReputation::RELATION_REPLAY)
            ->where('rating', 1);
    }

    /**
     * @return mixed
     */
    public function negative()
    {
        return $this->hasMany('App\Models\UserReputation', 'object_id')
            ->where('relation', UserReputation::RELATION_REPLAY)
            ->where('rating', '-1');
    }

    /**
     * Get all of the comments for the User Replay.
     *
     * @return mixed
     */
    public function replayUserComments()
    {
        return $this->hasManyThrough(
            'App\Models\Comment',
            'App\User',
            'id',
            'user_id',
            'user_id',
            'id'
        );

    }
}
