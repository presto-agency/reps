<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InterviewUserAnswers extends Model
{

    protected $fillable = [
        'question_id', 'answer_id', 'user_id'
    ];

//    // Relations
//    public function questions()
//    {
//        return $this->belongsTo(\App\Models\InterviewQuestion::class, 'question_id', 'id');
//    }
//
//    public function variantAnswers()
//    {
//        return $this->belongsTo(\App\Models\InterviewVariantAnswer::class, 'answer_id', 'id');
//    }
//
//    public function users()
//    {
//        return $this->belongsTo(\App\User::class, 'user_id', 'id');
//    }
}
