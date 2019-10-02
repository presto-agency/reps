<?php

namespace App\Traits\ModelRelations;

/**
 * Trait UserRelation
 * @package App\Traits\ModelRelations
 */
trait InterviewQuestionRelationTrait
{

    public function answers()
    {

        return $this->hasMany('App\Models\InterviewUserAnswers', 'question_id');

    }

}
