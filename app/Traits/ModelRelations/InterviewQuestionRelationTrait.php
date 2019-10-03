<?php

namespace App\Traits\ModelRelations;


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

}
