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
        InterviewQuestionObserver::$answers = $poll->getAttribute('answer');
        unset($poll['answer']);

    }

    /**
     * @param InterviewQuestion $poll
     */
    public function created(InterviewQuestion $poll)
    {
        self::storeIVA(InterviewQuestionObserver::$answers, $poll->getAttribute('id'));
    }

    /**
     * @param InterviewQuestion $poll
     */
    public function updating(InterviewQuestion $poll)
    {
        InterviewQuestionObserver::$answersEdit = $poll->getAttribute('answer');
        unset($poll['answer']);
    }

    /**
     * @param InterviewQuestion $poll
     */
    public function updated(InterviewQuestion $poll)
    {
        self::updateIVA(InterviewQuestionObserver::$answersEdit, $poll->getAttribute('id'));
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

    /**
     * Store InterviewVariantAnswer
     * @param $getAnswers
     * @param $id
     */
    public static function storeIVA($getAnswers, $id)
    {
        if (!empty($getAnswers)) {
            foreach ($getAnswers as $answer) {
                if (!empty($answer)) {
                    $addAnswer = new InterviewVariantAnswerController;
                    $addAnswer->store($id, $answer);
                }
            }
        }
    }

    /**
     * Update InterviewVariantAnswer
     * @param $answersEdit
     * @param $questionId
     */
    public static function updateIVA($answersEdit, $questionId)
    {
        if (!empty($answersEdit)) {
            foreach ($answersEdit as $id => $answerEdit) {
                if (!empty($answerEdit)) {
                    $addAnswers = new InterviewVariantAnswerController;
                    $addAnswers->update($id, $answerEdit, $questionId);
                }
            }
        }
    }
}
