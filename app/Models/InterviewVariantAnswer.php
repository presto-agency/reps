<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InterviewVariantAnswer extends Model
{
    protected $fillable = [
        'question_id', 'answer',
    ];
}
