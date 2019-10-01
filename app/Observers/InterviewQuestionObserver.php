<?php

namespace App\Observers;

use App\Http\Controllers\Admin\InterviewVariantAnswerController;
use App\Models\InterviewQuestion;

class InterviewQuestionObserver
{

    public static $answers;
    public static $answersEdit;

    /**
     * @param InterviewQuestion $poll
     */

    public function creating(InterviewQuestion $poll)
    {
        $data = $poll->getAttributes();
        if (array_key_exists('answer', $data)) {
            InterviewQuestionObserver::$answers = $data['answer'];
            unset($poll['answer']);
        }

    }

    /**
     * @param InterviewQuestion $poll
     */
    public function created(InterviewQuestion $poll)
    {
        $answers = InterviewQuestionObserver::$answers;
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
    public function updating(InterviewQuestion $poll)
    {

        $data = $poll->getAttributes();
        if (array_key_exists('answer', $data)) {
            InterviewQuestionObserver::$answersEdit = $data['answer'];
            unset($poll['answer']);
        }

    }

    /**
     * @param InterviewQuestion $poll
     */
    public function updated(InterviewQuestion $poll)
    {
        $answersEdit = InterviewQuestionObserver::$answersEdit;
        $questionId = $poll->id;

        if (!empty($questionId)) {
                foreach ($answersEdit as $key => $answerEdit) {
                    if (!empty($answerEdit)) {
                        $addAnswers = new InterviewVariantAnswerController;
                        $addAnswers->update($key, $answerEdit);
                    }
                };
        }

    }

    /**
     * @param InterviewQuestion $poll
     */
    public function deleted(InterviewQuestion $poll)
    {
        $questionId = $poll->id;
        if (!empty($questionId)) {
            $addAnswers = new InterviewVariantAnswerController;
            $addAnswers->deletedAll($questionId);
        }
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
