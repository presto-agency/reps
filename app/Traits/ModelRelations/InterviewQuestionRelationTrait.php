<?php

namespace App\Traits\ModelRelations;


use App\Models\InterviewVariantAnswer;
use App\User;

trait InterviewQuestionRelationTrait
{

    public function answers()
    {
        return $this->hasMany(InterviewVariantAnswer::class, 'question_id');
    }

    public function userAnswers()
    {
        return $this->belongsToMany(InterviewVariantAnswer::class,
            'interview_user_answers',
            'question_id',
            'answer_id'
        );
    }

    public function users()
    {
        return $this->belongsToMany(User::class,
            'interview_user_answers',
            'question_id',
            'user_id'
        );
    }

}
