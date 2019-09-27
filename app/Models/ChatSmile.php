<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class ChatSmile extends Model
{
    protected $fillable = [
        'user_id', 'image', 'comment', 'charactor',
    ];
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
