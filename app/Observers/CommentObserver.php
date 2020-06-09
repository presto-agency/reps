<?php

namespace App\Observers;

use App\Events\UserComment;
use App\Models\Comment;

class CommentObserver
{

    /**
     * Handle the comment "created" event.
     *
     * @param  Comment  $comment
     *
     * @return void
     */
    public function created(Comment $comment)
    {
        event(new UserComment($comment));
    }

    /**
     * Handle the comment "updated" event.
     *
     * @param  Comment  $comment
     *
     * @return void
     */
    public function updated(Comment $comment)
    {
        //
    }

    /**
     * Handle the comment "deleted" event.
     *
     * @param  Comment  $comment
     *
     * @return void
     */
    public function deleted(Comment $comment)
    {
        //
    }

    /**
     * Handle the comment "restored" event.
     *
     * @param  Comment  $comment
     *
     * @return void
     */
    public function restored(Comment $comment)
    {
        //
    }

    /**
     * Handle the comment "force deleted" event.
     *
     * @param  Comment  $comment
     *
     * @return void
     */
    public function forceDeleted(Comment $comment)
    {
        //
    }

}
