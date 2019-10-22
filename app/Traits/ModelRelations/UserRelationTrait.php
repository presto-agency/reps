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

    public function totalReplays()
    {
        return $this->hasMany(\App\Models\Replay::class, 'user_id', 'id');
    }

    public function totalNews()
    {
        return $this->hasMany(\App\Models\ForumTopic::class, 'user_id', 'id')->whereNews(1);
    }

    public function totalComments()
    {
        return $this->hasMany(\App\Models\Comment::class, 'user_id', 'id');
    }
}
