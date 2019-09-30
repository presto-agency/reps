<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InterviewQuestion extends Model
{
    protected $fillable = [
        'question', 'active', 'for_login', 'count_answer'
    ];

}
