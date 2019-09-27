<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InterviewUserAnswers extends Model
{

    protected $fillable = [
        'question_id', 'answer_id', 'user_id'
    ];

    public function setUserIdAttribute($value)
    {
        if ($value) {
            $this->attributes['user_id'] = auth()->user()->id;
        }
    }

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
