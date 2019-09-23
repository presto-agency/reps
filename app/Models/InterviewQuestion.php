<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InterviewQuestion extends Model
{
    protected $fillable = [
        'question', 'active', 'for_login', 'count_answer'
    ];


    // Relations
    public function usersAnswers()
    {

        return $this->hasMany(InterviewUserAnswers::class, 'question_id');
    }

    public function variantAnswers()
    {
        return $this->hasMany(InterviewVariantAnswer::class, 'question_id');
    }
}
