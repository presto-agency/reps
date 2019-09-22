<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class PollAnswer extends Model
{

    protected $fillable = [
        'poll_id', 'question_id', 'user_id'
    ];

    // Relations
    public function pollAnswerToPoll()
    {
        return $this->belongsTo(Poll::class, 'poll_id', 'id');
    }

    // Relations
    public function pollAnswerToQuestion()
    {
        return $this->belongsTo(PollQuestion::class, 'question_id', 'id');
    }

    // Relations
    public function pollAnswerToUsers()
    {
        return $this->hasMany(User::class, 'user_id', 'id');
    }
}
