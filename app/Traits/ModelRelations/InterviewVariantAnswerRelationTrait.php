<?php

namespace App\Traits\ModelRelations;


trait InterviewVariantAnswerRelationTrait
{

    public function userAnswers()
    {

        return $this->hasMany('App\Models\InterviewUserAnswers', 'answer_id');

    }

}
