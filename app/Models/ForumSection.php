<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ForumSection extends Model
{

    protected $guarded
        = [
            'position',
            'name',
            'display_name',
            'description',
            'is_active',
            'is_general',
            'user_can_add_topics',
            'bot',
            'bot_script',
        ];

    public function topics()
    {
        return $this->hasMany('App\Models\ForumTopic', 'forum_section_id', 'id');
    }


    public function topicsCount()
    {
        return $this->hasMany('App\Models\ForumTopic', 'forum_section_id', 'id')->count();
    }

    /**
     * Get all of the comments for the ForumSection.
     */
    public function forumSectionComments()
    {
        return $this->hasManyThrough(
            'App\Models\Comment',
            'App\Models\ForumTopic',
            'forum_section_id', // Foreign key on ForumTopic table...
            'commentable_id', // Foreign key on comments table...
            'id', // Local key on ForumSection table...
            'id' // Local key on ForumTopic table...
        );
    }

}
