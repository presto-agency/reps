<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller as Controller;
use App\Models\InterviewVariantAnswer;

class InterviewVariantAnswerController extends Controller
{

    /**
     * @param $question_id
     * @param $answer
     */
    public function store($question_id, $answer)
    {
        $store = new InterviewVariantAnswer;
        $store->question_id = $question_id;
        $store->answer = $answer;
        $store->save();

    }

    /**
     * @param $id
     * @param $answer
     * @param $question_id
     */
    public function update($id, $answer, $question_id)
    {
        $update = InterviewVariantAnswer::where('id', $id)->first();
        if (!$update) {
            $this->store($question_id, $answer);
        }
        if (!empty($update)) {
            if ($update->answer != $answer) {
                $update->answer = $answer;
                $update->save();
            }
        }
    }

    public function delete($id)
    {
        InterviewVariantAnswer::destroy($id);
        return back();
    }
}
