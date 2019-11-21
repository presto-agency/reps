<?php

namespace App\Traits\ModelRelations;


use App\Models\Country;
use App\Models\Race;
use App\User;

trait StreamRelationTrait
{

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function races()
    {
        return $this->belongsTo(Race::class, 'race_id', 'id');
    }

    public function countries()
    {
        return $this->belongsTo(Country::class, 'country_id', 'id');
    }

}
