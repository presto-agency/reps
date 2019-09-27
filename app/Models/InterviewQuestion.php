<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InterviewQuestion extends Model
{
    protected $fillable = [
        'question', 'active', 'for_login', 'count_answer'
    ];


//    public function users()
//    {
//
//        return $this->hasMany(\App\Models\InterviewUserAnswers::class, 'user_id', 'id');
//    }
//
//    public function answers()
//    {
//        return $this->hasMany(\App\Models\InterviewVariantAnswer::class, 'answer_id', 'id');
//    }
//
//    public function questions()
//    {
//        return $this->belongsTo(\App\Models\InterviewVariantAnswer::class, 'question_id', 'id');
//    }
}
