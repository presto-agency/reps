<?php

namespace App\Policies;


use App\Http\Sections\Tournaments;
use App\Models\TourneyList as Tourney;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TourneyListPolicy
{

    use HandlesAuthorization;


    public function before(User $user, $ability, Tournaments $section, Tourney $item = null)
    {
    }


    public function display(User $user, Tournaments $section, Tourney $item)
    {
        return true;
    }

    public function create(User $user, Tournaments $section, Tourney $item)
    {
        return true;
    }

    public function edit(User $user, Tournaments $section, Tourney $item)
    {
        //        $status = Tourney::$status[$item->status];
        //        if ($status === 'ANNOUNCE' || $status === 'REGISTRATION' || $status === 'CHECK-IN' || $status === 'STARTED') {
        //            return true;
        //        }

        return true;
    }


    public function delete(User $user, Tournaments $section, Tourney $item)
    {
        return true;
    }

}
