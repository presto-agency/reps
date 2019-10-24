<?php

namespace App\Traits\ModelRelations;

trait InterviewVariantAnswerRelationTrait
{

    public function userAnswers()
    {
        return $this->hasMany(\App\Models\InterviewUserAnswers::class,'answer_id');
    }
    public function question()
    {
        return $this->belongsTo(\App\Models\InterviewQuestion::class,'question_id');
    }

}
