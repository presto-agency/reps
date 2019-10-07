<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InterviewUserAnswers extends Model
{

    protected $fillable = [
        'question_id', 'answer_id', 'user_id'
    ];


}
