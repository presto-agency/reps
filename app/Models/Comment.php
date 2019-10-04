<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = [
        'user_id', 'commentable_id', 'commentable_type', 'title', 'content', 'rating', 'negative_count', 'positive_count'
    ];
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    /**
     * Get the owning commentable model.
     */
    public function commentable()
    {
        return $this->morphTo();
    }
}
