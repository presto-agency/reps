<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class ForumTopic extends Model
{
    protected $fillable = [
        'title', 'forum_section_id', 'user_id', 'reviews', 'rating', 'preview_content', 'preview_img', 'content', 'comments_count', 'news', 'start_on',
    ];
    public function forumSection()
    {
        return $this->belongsTo(ForumSection::class, 'forum_section_id');
    }
    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
