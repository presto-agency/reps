<?php

namespace App\Http\Controllers\Replay;

use App\Http\Controllers\Controller;
use App\Models\Replay;

class ReplayProTypeController extends Controller
{
    public function index($type)
    {
        $ArrRelations = [
            'users:id,name,avatar',
            'maps:id,name',
            'firstCountries:id,flag',
            'secondCountries:id,flag',
            'firstRaces:id,title,code',
            'secondRaces:id,title,code',
            'types:id,name,title',
        ];
        $ArrColumn = [
            'id',
            'title',
            'user_id',
            'map_id',
            'first_name',
            'second_name',
            'first_country_id',
            'second_country_id',
            'first_race',
            'second_race',
            'positive_count',
            'negative_count',
            'created_at',
        ];

        $replay = ReplayController::getReplaysWithType($ArrRelations, $ArrColumn, Replay::REPLAY_PRO, $type);
        $proRout = ReplayController::checkUrlPro() === true ? true : false;
        $proRoutType = ReplayController::checkUrlProType($type) === true ? true : false;
        return view('replay.index',
            compact('replay', 'proRout', 'proRoutType', 'type')
        );
    }

    public function show($type, $id)
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
        $replay = ReplayController::findReplay($ArrRelations, $id);
        $countUserPts = $replay->users->totalComments->count();
        $proRout = ReplayController::checkUrlPro() === true ? true : false;
        $proRoutType = ReplayController::checkUrlProType($type) === true ? true : false;
        return view('replay.show',
            compact('replay', 'proRout', 'countUserPts', 'proRoutType', 'type')
        );
    }

}
