<?php

namespace App\Http\Controllers\Replay;

use App\Http\Controllers\Controller;
use App\Models\Replay;

class ReplayProTypeController extends Controller
{
    public function index($type)
    {


        $replay = ReplayController::getReplaysWithType($ArrRelations, $ArrColumn, Replay::REPLAY_PRO);
        $proRout = ReplayController::checkUrlPro() === true ? true : false;
        return view('replay.index',
            compact('replay', 'proRout')
        );
    }

    public function show($replay_pro)
    {

        $ArrRelations = [
            'users:id,name,avatar,count_positive,count_negative',
            'users.totalComments',
            'maps:id,name,url',
            'types:id,name,title',
            'firstCountries:id,name,flag',
            'secondCountries:id,name,flag',
            'firstRaces:id,title,code',
            'secondRaces:id,title,code',
        ];
        $replay = ReplayController::findReplay($ArrRelations, $replay_pro);
        $countUserPts = $replay->users->totalComments->count();
        $proRout = ReplayController::checkUrlPro() === true ? true : false;
        return view('replay.index',
            compact('replay', 'proRout')
        );
    }
}
