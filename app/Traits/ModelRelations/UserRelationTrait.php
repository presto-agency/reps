<?php

namespace App\Traits\ModelRelations;


trait UserRelation
{

    public function roles()
    {
        return $this->belongsTo(\App\Models\Role::class, 'role_id', 'id');
    }

    public function countries()
    {
        return $this->belongsTo(\App\Models\Country::class, 'country_id', 'id');
    }

    public function races()
    {
        return $this->belongsTo(\App\Models\Race::class, 'race_id', 'id');
    }


}
