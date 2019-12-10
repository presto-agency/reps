<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InterviewUserAnswers extends Model
{

    protected $fillable
        = [
            'answer_id',
        ];

    protected $hidden
        = [
            'question_id',
            'user_id',
        ];

}
