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

        $interviewVariantAnswers = InterviewVariantAnswer::where('question_id', $id)
            ->with('userAnswers')->get(['id', 'answer']);

        $content = view('admin.InterviewQuestion.show',
            compact('interviewQuestion', 'interviewVariantAnswers')
        );

        return AdminSection::view($content, 'Show');
    }
}
