<?php

namespace App\Traits\ModelRelations;

/**
 * Trait UserRelation
 * @package App\Traits\ModelRelations
 */
trait UserActivityLogRelationTrait
{
    public function types()
    {
        return $this->belongsTo(\App\Models\UserActivityType::class, 'type_id', 'id');
    }

    public function users()
    {
        return $this->belongsTo(\App\User::class, 'user_id', 'id');
    }


}
