<?php

namespace App\Policies;

use App\Http\Sections\TournamentsMatches;
use App\Models\TourneyList;
use App\Models\TourneyMatch as Match;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TourneyMatchPolicy
{

    use HandlesAuthorization;

    public function __construct()
    {
    }

    public function before(User $user, $ability, TournamentsMatches $section, Match $item = null)
    {
    }

    public function display(User $user, TournamentsMatches $section, Match $item)
    {
        return true;
    }

    public function create(User $user, TournamentsMatches $section, Match $item)
    {
        return true;
    }

    public function edit(User $user, TournamentsMatches $section, Match $item)
    {
        if ( ! empty($item->tourney)) {
            $status = TourneyList::$status[$item->tourney->status];
            if ($status === 'STARTED') {
                return true;
            }

            return false;
        }

        return true;
    }


    public function delete(User $user, TournamentsMatches $section, Match $item)
    {
        if ( ! empty($item->tourney)) {
            $status = TourneyList::$status[$item->tourney->status];
            if ($status === 'STARTED') {
                return true;
            }

            return false;
        }

        return true;
    }

}
