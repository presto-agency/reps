<?php

namespace App\Policies;

use App\Http\Sections\TournamentsPlayer;
use App\Models\TourneyList;
use App\Models\TourneyPlayer as Players;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TourneyPlayersPolicy
{

    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function before(User $user, $ability, TournamentsPlayer $section, Players $item = null)
    {
    }


    public function display(User $user, TournamentsPlayer $section, Players $item)
    {
        return true;
    }

    public function create(User $user, TournamentsPlayer $section, Players $item)
    {
        return true;
    }

    public function edit(User $user, TournamentsPlayer $section, Players $item)
    {
        if ( ! empty($item->tourney)) {
            $status = TourneyList::$status[$item->tourney->status];
            if ($status === 'ANNOUNCE' || $status === 'REGISTRATION' || $status === 'CHECK-IN' || $status === 'STARTED') {
                return true;
            }
        } else {
            return true;
        }


        return false;
    }


    public function delete(User $user, TournamentsPlayer $section, Players $item)
    {
        if ( ! empty($item->tourney)) {
            $status = TourneyList::$status[$item->tourney->status];
            if ($status === 'ANNOUNCE' || $status === 'REGISTRATION' || $status === 'CHECK-IN' || $status === 'STARTED') {
                return true;
            }
        } else {
            return true;
        }


        return false;
    }

}
