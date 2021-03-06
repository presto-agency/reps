<?php

namespace App\Policies;

use App\Http\Sections\TournamentsMapPool;
use App\Models\TourneyList;
use App\Models\TourneyListsMapPool as MapPoll;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TourneyMapPollPolicy
{

    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    public function before(User $user, $ability, TournamentsMapPool $section, MapPoll $item = null)
    {
    }


    public function display(User $user, TournamentsMapPool $section, MapPoll $item)
    {
        return true;
    }

    public function create(User $user, TournamentsMapPool $section, MapPoll $item)
    {
        return true;
    }

    public function edit(User $user, TournamentsMapPool $section, MapPoll $item)
    {
        if ( ! empty($item->tourney)) {
            $status = TourneyList::$status[$item->tourney->status];
            if ($status === 'ANNOUNCE' || $status === 'REGISTRATION' || $status === 'CHECK-IN') {
                return true;
            }

            return false;
        }

        return true;
    }


    public function delete(User $user, TournamentsMapPool $section, MapPoll $item)
    {
        if ( ! empty($item->tourney)) {
            $status = TourneyList::$status[$item->tourney->status];
            if ($status === 'ANNOUNCE' || $status === 'REGISTRATION' || $status === 'CHECK-IN') {
                return true;
            }

            return false;
        }

        return true;
    }

}
