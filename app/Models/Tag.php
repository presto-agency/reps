<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{

    protected $fillable
        = [
            'name', 'display_name',
        ];

    public function chatPictures()
    {
        return $this->belongsToMany('App\Models\ChatPicture',
            'chat_picture_tag', 'tag_id', 'chat_picture_id');
    }

}
