<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller as Controller;
use App\Models\InterviewVariantAnswer;

class InterviewVariantAnswerController extends Controller
{


    public function store($questionId, $answer)
    {

        $store = new InterviewVariantAnswer;
        $store->question_id = $questionId;
        $store->answer = $answer;
        $store->save();

    }

    public function update($id, $answer)
    {
        dd($id,$answer);
        $update = InterviewVariantAnswer::where('id', $id)->first();
        $update->answer = $answer;
        $update->save();

    }

    public function deletedAll($id)
    {
        InterviewVariantAnswer::where('question_id', $id)->delete();
    }

    public function destroy($id)
    {

        InterviewVariantAnswer::destroy($id);
        return redirect()->to("http://reps.loc/admin/interview_questions/10/edit");
    }
}
