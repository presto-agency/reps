<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class InterviewUserAnswers extends Model
{

    protected $fillable = [
        'question_id', 'answer_id', 'user_id'
    ];

    // Relations
    public function question()
    {
        return $this->belongsTo(InterviewQuestion::class, 'question_id', 'id');
    }
    public function answer()
    {
        return $this->belongsTo(InterviewVariantAnswer::class, 'answer_id', 'id');
    }
    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
