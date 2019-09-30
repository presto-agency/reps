<?php

namespace App\Observers;

use App\Http\Controllers\Admin\InterviewVariantAnswerController;
use App\Models\InterviewQuestion;

class InterviewQuestionObserver
{

    public static $answer;

    /**
     * @param InterviewQuestion $poll
     */

    public function creating(InterviewQuestion $poll)
    {
        $data = $poll->getAttributes();
        if (array_key_exists('answer', $data)) {

            InterviewQuestionObserver::$answer = $data['answer'];
            unset($poll['answer']);

        }

    }

    /**
     * @param InterviewQuestion $poll
     */
    public function created(InterviewQuestion $poll)
    {
        $answers = InterviewQuestionObserver::$answer;
        $questionId = $poll->id;

        if (!empty($questionId)) {
            foreach ($answers as $key => $answer) {
                if (!empty($answer)) {
                    $addAnswers = new InterviewVariantAnswerController;
                    $addAnswers->store($questionId, $answer);
                }
            };
        }
    }


    /**
     * @param InterviewQuestion $poll
     */
    public function updated(InterviewQuestion $poll)
    {
        //
    }

    /**
     * @param InterviewQuestion $poll
     */
    public function deleted(InterviewQuestion $poll)
    {
        //
    }

    /**
     * @param InterviewQuestion $poll
     */
    public function restored(InterviewQuestion $poll)
    {
        //
    }

    /**
     * @param InterviewQuestion $poll
     */
    public function forceDeleted(InterviewQuestion $poll)
    {
        //
    }
}
