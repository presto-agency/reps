<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller as Controller;
use App\Models\InterviewVariantAnswer;

class InterviewVariantAnswerController extends Controller
{


    public function store($questionId,$answer)
    {

        $insert = new InterviewVariantAnswer;
        $insert->question_id = $questionId;
        $insert->answer = $answer;
        $insert->save();

    }
}
