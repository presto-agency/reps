<?php

namespace App\Observers;

use App\Events\UserUploadForumTopic;
use App\Models\ForumTopic;
use Carbon\Carbon;

class ForumTopicObserver
{

    public function creating(ForumTopic $forumTopic)
    {
        $forumTopic->setAttribute('user_id', auth()->id());
        $forumTopic->setAttribute('commented_at', Carbon::now());
    }

    /**
     * Handle the forum topic "created" event.
     *
     * @param  ForumTopic  $forumTopic
     *
     * @return void
     */
    public function created(ForumTopic $forumTopic)
    {
        event(new UserUploadForumTopic($forumTopic));
    }

    public function updating(ForumTopic $forumTopic)
    {
        $forumTopic->setAttribute('user_id', auth()->id());
    }

    /**
     * Handle the forum topic "updated" event.
     *
     * @param  ForumTopic  $forumTopic
     *
     * @return void
     */
    public function updated(ForumTopic $forumTopic)
    {
        //
    }

    /**
     * Handle the forum topic "deleted" event.
     *
     * @param  ForumTopic  $forumTopic
     *
     * @return void
     */
    public function deleted(ForumTopic $forumTopic)
    {
        //
    }

    /**
     * Handle the forum topic "restored" event.
     *
     * @param  ForumTopic  $forumTopic
     *
     * @return void
     */
    public function restored(ForumTopic $forumTopic)
    {
        //
    }

    /**
     * Handle the forum topic "force deleted" event.
     *
     * @param  ForumTopic  $forumTopic
     *
     * @return void
     */
    public function forceDeleted(ForumTopic $forumTopic)
    {
        //
    }

}
