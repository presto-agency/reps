<?php

namespace App\Models;

use App\Traits\ModelRelations\InterviewVariantAnswerRelationTrait;
use Illuminate\Database\Eloquent\Model;

class InterviewVariantAnswer extends Model
{

    use InterviewVariantAnswerRelationTrait;

    protected $fillable
        = [
            'question_id', 'answer',
        ];

}
