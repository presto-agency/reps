<?php

namespace App\Traits\ModelSetAttributes;


trait InterviewUserAnswersSetAttribute
{

    public function setUserIdAttribute($value)
    {
        if ($value) {
            $this->attributes['user_id'] = auth()->user()->id;
        }
    }
}
