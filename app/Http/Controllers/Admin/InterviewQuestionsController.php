<?php

namespace App\Http\Controllers\Admin;

use AdminSection;
use App\Models\InterviewQuestion;
use App\Models\InterviewVariantAnswer;
use App\Http\Controllers\Controller;

class InterviewQuestionsController extends Controller
{
    public function show($id)
    {

        $interviewQuestion = InterviewQuestion::select('question')->findOrFail($id);

        $interviewVariantAnswers = InterviewVariantAnswer::select('id', 'answer')
            ->with('userAnswers')->where('question_id', $id)->get();

        $content = view('admin.InterviewQuestion.show',
            compact('interviewQuestion', 'interviewVariantAnswers')
        );

        return AdminSection::view($content, 'Show');
    }
}
