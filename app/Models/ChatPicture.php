<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class ChatPicture extends Model
{
    protected $fillable = [
        'user_id', 'image', 'comment', 'charactor', 'tag',
    ];
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
