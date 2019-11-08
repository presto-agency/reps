<?php

namespace App\Http\Controllers\Replay;

use App\Http\Requests\ReplayUpdateRequest;
use App\Models\Replay;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ReplayController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param $type
     * @param $subtype
     * @return \Illuminate\Http\Response
     */
    public function index($type = null, $subtype = null)
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

        $type = ReplayHelper::getReplayType();
        if (request()->has('subtype') && request()->filled('subtype')) {
            $replay = ReplayHelper::getReplaysWithType($relations, $type, request()->subtype);
        } else {
            $replay = ReplayHelper::getReplays($relations, $type);
        }

        $type = $type == Replay::REPLAY_USER ? 'user' : 'pro';
        $userReplayRout = ReplayHelper::checkUrl() === true ? true : false;
        return view('replay.index', compact('replay', 'type', 'userReplayRout'));
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
     * @param $type
     * @param $subtype
     * @return \Illuminate\Http\Response
     */
    public function show($id, $type = null, $subtype = null)
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

        $type = ReplayHelper::getReplayType();
        $userReplayRout = ReplayHelper::checkUrl() === true ? true : false;

        if (request()->has('subtype') && request()->filled('subtype')) {
            $replay = ReplayHelper::findReplaysWithType($relations, $id, $type, request()->subtype);
        } else {
            $replay = ReplayHelper::findReplayWithType2($relations, $id, $type);
        }

        $countUserPts = $replay->users->totalComments->count();
        $type = $type == Replay::REPLAY_USER ? 'user' : 'pro';
        return view('replay.show',
            compact('replay', 'countUserPts', 'type', 'userReplayRout')
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
     * @param ReplayUpdateRequest $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(ReplayUpdateRequest $request, $id)
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
