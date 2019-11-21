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

    public function replays()
    {
        return $this->hasMany(\App\Models\Replay::class, 'user_id', 'id');
    }

    public function news()
    {
        return $this->hasMany(\App\Models\ForumTopic::class, 'user_id', 'id')->whereNews(1);
    }

    public function images()
    {
        return $this->hasMany(\App\Models\UserGallery::class, 'user_id', 'id');
    }
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function user_friends()
    {
        return $this->hasMany('App\Models\UserFriend', 'user_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function user_friendly()
    {
        return $this->hasMany('App\Models\UserFriend', 'friend_user_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function topics()
    {
        return $this->hasMany('App\Models\ForumTopic', 'user_id','id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comments()
    {
        return $this->hasMany('App\Models\Comment', 'user_id','id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function user_replay()
    {
        return $this->hasMany('App\Models\Replay', 'user_id','id')->where('user_replay', 1);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function gosu_replay()
    {
        return $this->hasMany('App\Models\Replay', 'user_id','id')->where('user_replay', 0);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function messages()
    {
        return $this->hasMany('App\Models\UserMessage', 'user_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function dialogues()
    {
        return $this->belongsToMany('App\Models\Dialogue', 'user_messages');
    }

}
