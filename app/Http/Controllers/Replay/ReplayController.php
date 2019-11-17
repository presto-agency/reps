<?php

namespace App\Http\Controllers\Replay;

use App\Http\Requests\ReplayUpdateRequest;
use App\Models\Replay;
use App\Models\UserActivityLog;
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
    public function index($type = '')
    {
        $type = ReplayHelper::getReplayType() == Replay::REPLAY_USER ? 'user' : 'pro';
        $userReplayRout = ReplayHelper::checkUrl() === true ? true : false;
        if (request()->has('subtype') && request()->filled('subtype')) {
            $subtype = request('subtype');
        } else {
            $subtype = '';
        }

        return view('replay.index', compact('type', 'subtype', 'userReplayRout'));
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
            'users',
            'users.countries:id,name,flag',
            'users.races:id,title',

            'maps:id,name,url',
            'types:id,name,title',
            'firstCountries:id,name,flag,name',
            'secondCountries:id,name,flag,name',
            'firstRaces:id,title,code',
            'secondRaces:id,title,code',

            'comments',
            'comments.user:id,avatar,name,country_id,race_id,rating,count_negative,count_positive',
            'comments.user.countries:id,name,flag',
            'comments.user.races:id,title'
        ];

        $type = ReplayHelper::getReplayType();
        $userReplayRout = ReplayHelper::checkUrl() === true ? true : false;

        if (request()->has('subtype') && request()->filled('subtype')) {
            $replay = ReplayHelper::findReplaysWithType($relations, $id, $type, request()->subtype);
        } else {
            $replay = ReplayHelper::findReplayWithType2($relations, $id, $type);
        }
        $type = $type == Replay::REPLAY_USER ? 'user' : 'pro';
        return view('replay.show',
            compact('replay', 'type', 'userReplayRout')
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

    public function loadReplay()
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

        if (request()->ajax()) {
            $visible_title = false;
            $type = ReplayHelper::getReplayType();
            if (request('id') > 0) {
                if (request()->has('subtype') && request()->filled('subtype')) {
                    $replay = self::getReplayWithTypeAjaxId($relations, $type, request('subtype'), request('id'));
                    $subtype = request('subtype');
                } else {
                    $replay = self::getReplayAjaxId($relations, $type, request('id'));
                    $subtype = '';
                }
            } else {
                if (request()->has('subtype') && request()->filled('subtype')) {
                    $replay = self::getReplayWithTypeAjax($relations, $type, request('subtype'));
                    $subtype = request('subtype');
                } else {
                    $replay = self::getReplayAjax($relations, $type);
                    $subtype = '';
                }
                $visible_title = true;
            }
            $type = $type == Replay::REPLAY_USER ? 'user' : 'pro';
            $userReplayRout = ReplayHelper::checkUrl() === true ? true : false;
            echo view('replay.components.index',
                compact('replay', 'visible_title', 'type', 'subtype', 'userReplayRout')
            );
        }
    }


    public static function getReplayWithTypeAjaxId($relations, $user_replay, $type, $id)
    {
        return Replay::with($relations)
            ->orderByDesc('id')
            ->withCount('comments')
            ->where('id', '<', $id)
            ->where('approved', 1)
            ->where('user_replay', $user_replay)
            ->whereHas('types', function ($query) use ($type) {
                $query->where('name', $type);
            })
            ->limit(5)
            ->get();
    }

    public static function getReplayAjaxId($relations, $user_replay, $id)
    {
        return Replay::with($relations)
            ->orderByDesc('id')
            ->withCount('comments')
            ->where('approved', 1)
            ->where('user_replay', $user_replay)
            ->where('id', '<', $id)
            ->limit(5)
            ->get();
    }


    public static function getReplayWithTypeAjax($relations, $user_replay, $type)
    {
        return Replay::with($relations)
            ->orderByDesc('id')
            ->withCount('comments')
            ->where('approved', 1)
            ->where('user_replay', $user_replay)
            ->whereHas('types', function ($query) use ($type) {
                $query->where('name', $type);
            })
            ->limit(5)
            ->get();
    }

    public static function getReplayAjax($relations, $user_replay)
    {
        return Replay::with($relations)
            ->orderByDesc('id')
            ->withCount('comments')
            ->where('approved', 1)
            ->where('user_replay', $user_replay)
            ->limit(5)
            ->get();
    }
}
