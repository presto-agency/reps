<?php

namespace App\Models;

use App\Traits\ModelSetAttributes\InterviewUserAnswersSetAttribute;
use Illuminate\Database\Eloquent\Model;

class InterviewUserAnswers extends Model
{
    use InterviewUserAnswersSetAttribute;

    protected $fillable = [
        'question_id', 'answer_id', 'user_id'
    ];


}
