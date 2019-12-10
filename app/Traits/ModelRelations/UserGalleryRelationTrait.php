<?php

namespace App\Traits\ModelRelations;


use App\Models\UserReputation;
use App\User;

trait UserGalleryRelationTrait
{

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * Get all of the topic comments.
     */
    public function comments()
    {
        return $this->morphMany('App\Models\Comment', 'commentable');
    }
    public function commentsCount()
    {
        return $this->morphMany('App\Models\Comment', 'commentable')->count();
    }



    /**
     * @return HasMany
     */
    public function positive()
    {
        return $this->hasMany('App\Models\UserReputation', 'object_id')
            ->where('relation', UserReputation::RELATION_USER_GALLERY)
            ->where('rating', 1);
    }

    /**
     * @return HasMany
     */
    public function negative()
    {
        return $this->hasMany('App\Models\UserReputation', 'object_id')
            ->where('relation', UserReputation::RELATION_USER_GALLERY)
            ->where('rating', '-1');
    }
}
