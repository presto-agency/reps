<?php

namespace App\Traits\ModelRelations;

use App\Models\{Country, Race, Role, UserActivityLog, UserGallery};

/**
 * Trait UserRelation
 * @package App\Traits\ModelRelations
 */
trait UserRelation
{

    public function roles()
    {
        return $this->belongsTo(Role::class, 'role_id', 'id');
    }

    public function countries()
    {
        return $this->belongsTo(Country::class, 'country_id', 'id');
    }

    public function races()
    {
        return $this->belongsTo(Race::class, 'race_id', 'id');
    }

    public function galleries()
    {
        return $this->hasMany(UserGallery::class, 'user_id', 'id');
    }

    public function logs()
    {
        return $this->hasMany(UserActivityLog::class, 'user_id', 'id');
    }

}
