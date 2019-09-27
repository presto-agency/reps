<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InterviewVariantAnswer extends Model
{
    protected $fillable = [
        'question_id', 'answer',
    ];


//    public function questions()
//    {
//        return $this->belongsTo(\App\Models\InterviewQuestion::class, 'question_id', 'id');
//    }
//
//    public function userAnswers()
//    {
//        return $this->belongsTo(\App\Models\InterviewQuestion::class, 'answer_id', 'id');
//    }
//
//    public function users()
//    {
//        return $this->belongsTo(\App\Models\InterviewQuestion::class, 'user_id', 'id');
//    }
}
