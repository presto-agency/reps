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
        $relations = [
            'users:id,name,avatar',
            'maps:id,name',
            'firstCountries:id,flag,name',
            'secondCountries:id,flag,name',
            'firstRaces:id,title,code',
            'secondRaces:id,title,code',
            'comments',
        ];

        $replay = ReplayHelper::getReplays($relations, Replay::REPLAY_PRO);
//        $proRout = ReplayHelper::checkUrlPro() === true ? ReplayHelper::$REPLAY_PRO : false;
//        $proRoutType = false;

        return view('replay.index',
            compact('replay')
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return redirect()->to('/');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return redirect()->to('/');

    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $relations = [
            'users:id,name,avatar,count_positive,count_negative',
            'users.totalComments',
            'maps:id,name,url',
            'types:id,name,title',
            'firstCountries:id,flag,name',
            'secondCountries:id,flag,name',
            'firstRaces:id,title,code',
            'secondRaces:id,title,code',
            'comments',
        ];
        $replay = ReplayHelper::findReplayWithType2($relations, $id,Replay::REPLAY_PRO);
        $countUserPts = $replay->users->totalComments->count();
//        $proRout = ReplayHelper::checkUrlPro() === true ? ReplayHelper::$REPLAY_PRO : false;
//        $proRoutType = false;
        return view('replay.show',
            compact('replay', 'countUserPts')
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
        return redirect()->to('/');
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
        return redirect()->to('/');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return redirect()->to('/');

    }


}
