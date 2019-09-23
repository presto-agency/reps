<?php

namespace App\Observers;

use App\Models\InterviewQuestion;

class InterviewQuestionObserver
{

    private static $data;

    /**
     * @param InterviewQuestion $poll
     */
    public function creating(InterviewQuestion $poll)
    {
        InterviewQuestionObserver::$data = $poll->getAttributes();

    }

    /**
     * @param InterviewQuestion $poll
     */
    public function created(InterviewQuestion $poll)
    {
//        dd($poll->id, InterviewQuestionObserver::$data);
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
