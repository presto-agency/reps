<?php

namespace App\Observers;

use App\Models\PublicChat;
use App\User;

class PublicChatObserver
{
    /**
     * Handle the public chat "created" event.
     *
     * @param  \App\Models\PublicChat  $publicChat
     * @return void
     */
    public function created(PublicChat $publicChat)
    {
        $users = User::where('ban_chat','>', 0)->decrement('ban_chat');
    }

    /**
     * Handle the public chat "updated" event.
     *
     * @param  \App\Models\PublicChat  $publicChat
     * @return void
     */
    public function updated(PublicChat $publicChat)
    {
        //
    }

    /**
     * Handle the public chat "deleted" event.
     *
     * @param  \App\Models\PublicChat  $publicChat
     * @return void
     */
    public function deleted(PublicChat $publicChat)
    {
        //
    }

    /**
     * Handle the public chat "restored" event.
     *
     * @param  \App\Models\PublicChat  $publicChat
     * @return void
     */
    public function restored(PublicChat $publicChat)
    {
        //
    }

    /**
     * Handle the public chat "force deleted" event.
     *
     * @param  \App\Models\PublicChat  $publicChat
     * @return void
     */
    public function forceDeleted(PublicChat $publicChat)
    {
        //
    }
}
