<?php

namespace App\Http\Controllers\Replay;

use App\Http\Controllers\Controller;
use App\Models\Replay;

class ReplayProTypeController extends Controller
{

    public function index($type)
    {
        $relations = [
            'users:id,name,avatar',
            'maps:id,name',
            'firstCountries:id,flag,name',
            'secondCountries:id,flag,name',
            'firstRaces:id,title,code',
            'secondRaces:id,title,code',
            'types:id,name,title',
            'comments',
        ];

        $replay = ReplayController::getReplaysWithType($relations, Replay::REPLAY_PRO, $type);
        $proRout = ReplayController::checkUrlPro() === true ? ReplayController::$REPLAY_PRO : false;
        $proRoutType = ReplayController::checkUrlProType($type) === true ? true : false;
        return view('replay.index',
            compact('replay', 'proRout', 'proRoutType', 'type')
        );
    }

    public function show($type, $id)
    {
        $relations = [
            'users:id,name,avatar,count_positive,count_negative',
            'users.totalComments',
            'maps:id,name,url',
            'types:id,name,title',
            'firstCountries:id,name,flag,name',
            'secondCountries:id,name,flag,name',
            'firstRaces:id,title,code',
            'secondRaces:id,title,code',
            'comments',
        ];
        $replay = ReplayController::findReplay($relations, $id);
        $countUserPts = $replay->users->totalComments->count();
        $proRout = ReplayController::checkUrlPro() === true ? ReplayController::$REPLAY_PRO : false;
        $proRoutType = ReplayController::checkUrlProType($type) === true ? ReplayController::$REPLAY_PRO : false;
        return view('replay.show',
            compact('replay', 'proRout', 'countUserPts', 'proRoutType', 'type')
        );
    }

}
