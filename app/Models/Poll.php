<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Poll extends Model
{
    protected $fillable = [
        'question', 'active', 'for_login', 'count_answer'
    ];


    // Relations
    public function pollToQuestions()
    {

        return $this->hasMany(PollQuestion::class);
    }

    public function pollToAnswers()
    {
        return $this->hasMany(PollAnswer::class);
    }
}
