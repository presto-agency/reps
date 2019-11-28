<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Comment extends Model
{
    const RELATION_FORUM_TOPIC  = 'App\Models\ForumTopic';
    const RELATION_REPLAY       = 'App\Models\Replay';
    const RELATION_USER_GALLERY = 'App\Models\UserGallery';

    protected $fillable
        = [
            'user_id', 'commentable_id', 'commentable_type', 'title', 'content',
            'rating', 'negative_count', 'positive_count',
        ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id','id');
    }

    /**
     * Get the owning commentable model.
     */
    public function commentable()
    {
        return $this->morphTo();
    }

    /**
     * @return HasMany
     */
    public function positive()
    {
        return $this->hasMany('App\Models\UserReputation', 'object_id')
            ->where('relation', UserReputation::RELATION_FORUM_TOPIC)
            ->where('rating', 1);
    }

    /**
     * @return HasMany
     */
    public function negative()
    {
        return $this->hasMany('App\Models\UserReputation', 'object_id')
            ->where('relation', UserReputation::RELATION_FORUM_TOPIC)
            ->where('rating', '-1');
    }

}
