<?php

namespace App\Traits\ModelRelations;


use App\User;

trait TourneyPlayerRelation
{

    /**
     * @return mixed
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

}
