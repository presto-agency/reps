<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class ChatPicture extends Model
{
    protected $fillable = [
        'user_id', 'image', 'comment', 'charactor',
    ];
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function tags()
    {
        return $this->belongsToMany('App\Models\Tag','chat_picture_tag', 'tag_id','chat_picture_id');
    }
}
