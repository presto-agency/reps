<?php

namespace App\Traits\ModelRelations;


trait UserGalleryRelationTrait
{

    public function users()
    {
        return $this->belongsTo(\App\User::class, 'user_id', 'id');
    }

    /**
     * Get all of the topic comments.
     */
    public function comments()
    {
        return $this->morphMany('App\Models\Comment', 'commentable');
    }
}
