<?php

namespace App\Traits\ModelRelations;


use App\Models\Country;
use App\Models\ForumTopic;
use App\Models\Race;
use App\Models\Replay;
use App\Models\Role;
use App\Models\UserGallery;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

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

    public function replays()
    {
        return $this->hasMany(Replay::class, 'user_id', 'id');
    }

    public function news()
    {
        return $this->hasMany(ForumTopic::class, 'user_id', 'id')
            ->whereNews(1);
    }

    public function images()
    {
        return $this->hasMany(UserGallery::class, 'user_id', 'id');
    }

    /**
     * @return HasMany
     */
    public function user_friends()
    {
        return $this->hasMany('App\Models\UserFriend', 'user_id');
    }

    /**
     * @return HasMany
     */
    public function user_friendly()
    {
        return $this->hasMany('App\Models\UserFriend', 'friend_user_id');
    }

    /**
     * @return HasMany
     */
    public function topics()
    {
        return $this->hasMany('App\Models\ForumTopic', 'user_id', 'id');
    }

    /**
     * @return HasMany
     */
    public function comments()
    {
        return $this->hasMany('App\Models\Comment', 'user_id', 'id');
    }

    /**
     * @return HasMany
     */
    public function user_replay()
    {
        return $this->hasMany('App\Models\Replay', 'user_id', 'id')
            ->where('user_replay', 1);
    }

    /**
     * @return HasMany
     */
    public function gosu_replay()
    {
        return $this->hasMany('App\Models\Replay', 'user_id', 'id')
            ->where('user_replay', 0);
    }

    /**
     * @return HasMany
     */
    public function messages()
    {
        return $this->hasMany('App\Models\UserMessage', 'user_id');
    }

    /**
     * @return BelongsToMany
     */
    public function dialogues()
    {
        return $this->belongsToMany('App\Models\Dialogue', 'user_messages');
    }

}
