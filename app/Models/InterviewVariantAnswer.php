<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InterviewVariantAnswer extends Model
{
    protected $fillable = [
        'question_id', 'answer',
    ];

    // Relations
    public function question()
    {
        return $this->belongsTo(InterviewQuestion::class, 'question_id', 'id');
    }
}
