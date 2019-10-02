<?php

namespace App\Models;

use App\Traits\ModelRelations\InterviewQuestionRelationTrait;
use Illuminate\Database\Eloquent\Model;

class InterviewQuestion extends Model
{
    use InterviewQuestionRelationTrait;

    protected $fillable = [
        'question', 'active', 'for_login', 'count_answer'
    ];

}
