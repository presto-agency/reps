<?php

namespace App\Http\Controllers\Admin;

use AdminSection;
use App\Http\Controllers\Controller;
use App\Models\InterviewQuestion;

class InterviewQuestionsController extends Controller
{

    public function show($id)
    {

        $data = InterviewQuestion::with([
            'answers' => function ($query) {
                $query->withCount('users');
            },
        ])->findOrFail($id);

        $content = view('admin.InterviewQuestion.show', compact('data'));

        return AdminSection::view($content, 'Show');
    }

}
