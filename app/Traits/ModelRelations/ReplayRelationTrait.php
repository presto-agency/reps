<?php

namespace App\Traits\ModelRelations;


trait ReplayRelationTrait
{

    public function users()
    {
        return $this->belongsTo(\App\User::class, 'user_id', 'id');
    }

    public function maps()
    {
        return $this->belongsTo(\App\Models\ReplayMap::class, 'map_id', 'id');
    }

    public function types()
    {
        return $this->belongsTo(\App\Models\ReplayType::class, 'type_id', 'id');
    }

    public function firstCountries()
    {
        return $this->belongsTo(\App\Models\Country::class, 'first_country_id', 'id');
    }
    public function secondCountries()
    {
        return $this->belongsTo(\App\Models\Country::class, 'second_country_id', 'id');
    }


    public function firstRaces()
    {
        return $this->belongsTo(\App\Models\Race::class, 'first_race', 'id');
    }

    public function secondRaces()
    {
        return $this->belongsTo(\App\Models\Race::class, 'second_race', 'id');
    }

}
