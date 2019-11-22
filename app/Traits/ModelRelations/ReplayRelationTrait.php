<?php

namespace App\Traits\ModelRelations;


use App\Models\Country;
use App\Models\Race;
use App\Models\ReplayMap;
use App\Models\ReplayType;
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

}
