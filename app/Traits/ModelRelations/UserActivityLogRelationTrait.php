<?php

namespace App\Traits\ModelRelations;


use App\Models\UserActivityType;
use App\User;

trait UserActivityLogRelationTrait
{

    public function types()
    {
        return $this->belongsTo(UserActivityType::class, 'type_id',
            'id');
    }

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }


}
