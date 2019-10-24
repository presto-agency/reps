<?php

namespace App\Http\Controllers\Admin;

use AdminSection;
use App\Http\Controllers\Controller;
use App\Models\InterviewQuestion;
use App\Models\InterviewVariantAnswer;

class InterviewQuestionsController extends Controller
{
    public function show($id)
    {
        $getIVA = InterviewVariantAnswer::where('question_id', $id)
            ->withCount('userAnswers')
            ->with('question:id,question')
            ->get();
        $data = [];
        $getQuestionName = null;
        foreach ($getIVA as $item) {
            $getQuestionName = $item->question->question;
            $data[] = [
                'answer' => $item->answer,
                'userAnswersCount' => $item->user_answers_count,
            ];
        }
        $content = view('admin.InterviewQuestion.show', compact('getQuestionName', 'data'));
        return AdminSection::view($content, 'Show');
    }
}
