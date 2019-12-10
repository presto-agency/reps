<?php

namespace App\Observers;

use App\Models\InterviewQuestion;

class InterviewQuestionObserver
{

    public static $answers;
    public static $answersEdit;

    /**
     * @param  InterviewQuestion  $poll
     */

    public function creating(InterviewQuestion $poll)
    {
        //        dd(request()->all());
        //        InterviewQuestionObserver::$answers = $poll->getAttribute('answers');
        //        unset($poll['answers']);
    }

    /**
     * @param  InterviewQuestion  $poll
     */
    public function created(InterviewQuestion $poll)
    {
        //        dd($poll);
        //        self::storeIVA(InterviewQuestionObserver::$answers, $poll->getAttribute('id'));
    }

    /**
     * @param  InterviewQuestion  $poll
     */
    public function updating(InterviewQuestion $poll)
    {
        //        InterviewQuestionObserver::$answersEdit = $poll->getAttribute('answers');
        //        unset($poll['answers']);
    }

    /**
     * @param  InterviewQuestion  $poll
     */
    public function updated(InterviewQuestion $poll)
    {
        //        self::updateIVA(InterviewQuestionObserver::$answersEdit, $poll->getAttribute('id'));
    }

    /**
     * @param  InterviewQuestion  $poll
     */
    public function deleted(InterviewQuestion $poll)
    {
        //
    }

    /**
     * @param  InterviewQuestion  $poll
     */
    public function restored(InterviewQuestion $poll)
    {
        //
    }

    /**
     * @param  InterviewQuestion  $poll
     */
    public function forceDeleted(InterviewQuestion $poll)
    {
        //
    }

    /**
     * Store InterviewVariantAnswer
     *
     * @param $answers
     * @param $id
     */
    public static function storeIVA($answers, $id)
    {
        //        if (!empty($answers)) {
        //            foreach ($answers as $answer) {
        //                if (!empty($answer) && strlen($answer) <= 255) {
        //
        //                    $addAnswer = new InterviewVariantAnswerController;
        //                    $addAnswer->store($id, $answer);
        //                }
        //            }
        //        }
    }

    /**
     * Update InterviewVariantAnswer
     *
     * @param $answersEdit
     * @param $questionId
     */
    public static function updateIVA($answersEdit, $questionId)
    {
        //        if (!empty($answersEdit)) {
        //            foreach ($answersEdit as $id => $answerEdit) {
        //                if (!empty($answerEdit) && strlen($answerEdit) <= 255) {
        //                    $addAnswers = new InterviewVariantAnswerController;
        //                    $addAnswers->update($id, $answerEdit, $questionId);
        //                }
        //            }
        //        }
    }

}
