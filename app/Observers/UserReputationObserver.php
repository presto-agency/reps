<?php

namespace App\Observers;

use App\Models\UserReputation;
use App\Services\Rating\RatingService;

class UserReputationObserver
{

    /**
     * Handle the user reputation "created" event.
     *
     * @param  \App\Models\UserReputation  $userReputation
     *
     * @return void
     */
    public function created(UserReputation $userReputation)
    {
        RatingService::refreshUserRating($userReputation->recipient_id);
        RatingService::refreshObjectRating($userReputation->object_id,
            $userReputation->relation);
    }

    /**
     * Handle the user reputation "updated" event.
     *
     * @param  \App\Models\UserReputation  $userReputation
     *
     * @return void
     */
    public function updated(UserReputation $userReputation)
    {
        RatingService::refreshUserRating($userReputation->recipient_id);
        RatingService::refreshObjectRating($userReputation->object_id,
            $userReputation->relation);
    }

    /**
     * Handle the user reputation "deleted" event.
     *
     * @param  \App\Models\UserReputation  $userReputation
     *
     * @return void
     */
    public function deleted(UserReputation $userReputation)
    {
        RatingService::refreshUserRating($userReputation->recipient_id);
        RatingService::refreshObjectRating($userReputation->object_id,
            $userReputation->relation);
    }

    /**
     * Handle the user reputation "restored" event.
     *
     * @param  \App\Models\UserReputation  $userReputation
     *
     * @return void
     */
    public function restored(UserReputation $userReputation)
    {
        RatingService::refreshUserRating($userReputation->recipient_id);
        RatingService::refreshObjectRating($userReputation->object_id,
            $userReputation->relation);
    }

    /**
     * Handle the user reputation "force deleted" event.
     *
     * @param  \App\Models\UserReputation  $userReputation
     *
     * @return void
     */
    public function forceDeleted(UserReputation $userReputation)
    {
        //
    }

}
