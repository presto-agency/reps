<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ForumSection extends Model
{
    protected $fillable = [
        'position', 'name', 'display_name', 'description', 'is_active', 'is_general', 'user_can_add_topics',
    ];
    public function topics()
    {
        return $this->hasMany('App\Models\ForumTopic');
    }
    public static function active()
    {
        return $general_forum = ForumSection::where('is_active',1)->orderBy('position');
    }
}
