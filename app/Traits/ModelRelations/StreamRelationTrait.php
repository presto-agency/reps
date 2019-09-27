<?php

namespace App\Traits\ModelRelations;

/**
 * Trait UserRelation
 * @package App\Traits\ModelRelations
 */
trait StreamRelationTrait
{

    public function users()
    {
        return $this->belongsTo(\App\User::class, 'user_id', 'id');
    }


}