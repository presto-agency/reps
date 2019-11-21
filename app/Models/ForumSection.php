<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class ForumSection extends Model
{
    protected $fillable = [
        'position',
        'name',
        'display_name',
        'description',
        'is_active',
        'is_general',
        'user_can_add_topics',
    ];

    public function topics()
    {
        return $this->hasMany('App\Models\ForumTopic','forum_section_id','id');
    }
    public function topicsCount()
    {
        return $this->hasMany('App\Models\ForumTopic','forum_section_id','id')->count();
    }

    public static function active()
    {
        return $general_forum = ForumSection::where('is_active', 1)->orderBy('position');
    }
//ForumSection
//id - integer
//name - string
//
//ForumTopic
//id - integer
//forum_section_id - integer
//name - string
//
//comments
//id - integer
//commentable_id - integer
//title - string
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
