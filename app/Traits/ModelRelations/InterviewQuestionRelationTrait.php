<?php

namespace App\Traits\ModelRelations;


use App\Http\Controllers\Interview\InterviewController;

trait InterviewQuestionRelationTrait
{

    public function answers()
    {
        return $this->hasMany('App\Models\InterviewVariantAnswer', 'question_id');
    }

    public function userAnswers()
    {
        return $this->hasMany('App\Models\InterviewUserAnswers', 'question_id');
    }

    public function userAlreadyAnswer()
    {
        return $this->hasMany('App\Models\InterviewUserAnswers', 'question_id')->whereUserId(InterviewController::getAuthUser()->id);
    }

}
