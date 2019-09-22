<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PollQuestion extends Model
{
    protected $fillable = [
        'poll_id', 'question',
    ];

    // Relations
    public function pollQuestionToPoll()
    {
        return $this->belongsTo(Poll::class, 'poll_id', 'id');
    }
}
