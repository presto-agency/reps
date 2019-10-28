<?php

namespace App\Http\Controllers\Replay;

use App\Models\Replay;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ReplayProController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ArrRelations = [
            'users:id,name,avatar',
            'maps:id,name',
            'firstCountries:id,flag',
            'secondCountries:id,flag',
            'firstRaces:id,title,code',
            'secondRaces:id,title,code',
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

        $replay = ReplayController::getReplays($ArrRelations, $ArrColumn, Replay::REPLAY_PRO);
        $proRout = ReplayController::checkUrlPro() === true ? true : false;
        $proRoutType = false;

        return view('replay.index',
            compact('replay', 'proRout', 'proRoutType')
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
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
        $proRoutType = false;
        return view('replay.show',
            compact('replay', 'countUserPts', 'proRout', 'proRoutType')
        );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

}
