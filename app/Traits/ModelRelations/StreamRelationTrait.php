<?php

namespace App\Traits\ModelRelations;


trait StreamRelationTrait
{

    public function users()
    {
        return $this->belongsTo(\App\User::class, 'user_id', 'id');
    }
    public function races()
    {
        return $this->belongsTo(\App\Models\Race::class, 'race_id', 'id');
    }
    public function countries()
    {
        return $this->belongsTo(\App\Models\Country::class, 'country_id', 'id');
    }

}
