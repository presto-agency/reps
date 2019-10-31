<?php

namespace App\Traits\ModelRelations;

use App\User;

trait InterviewVariantAnswerRelationTrait
{

    public function users()
    {
        return $this->belongsToMany(User::class,
            'interview_user_answers',
            'answer_id',
            'user_id'
        );
    }

}
