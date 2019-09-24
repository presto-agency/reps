<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ForumSection extends Model
{
    protected $fillable = [
        'position', 'name', 'display_name', 'description', 'is_active', 'is_general', 'user_can_add_topics',
    ];
}
