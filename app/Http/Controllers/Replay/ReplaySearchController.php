<?php

namespace App\Http\Controllers\Replay;

use App\Http\Controllers\Controller;
use App\Models\Replay;

class ReplaySearchController extends Controller
{

    public function index()
    {
        return view('replay.search');
    }

    public function loadReplay()
    {
        $request = request();
        if ($request->ajax()) {
            $visible_title = false;
            if ($request->id > 0) {
                $replaysSearch = $this->searchReplayQuery()
                    ->where('id', '<', $request->id)
                    ->where('approved', true)
                    ->orderByDesc('id')
                    ->limit(5)
                    ->get();
            } else {
                $replaysSearch = $this->searchReplayQuery()
                    ->where('approved', true)
                    ->orderByDesc('id')
                    ->limit(5)
                    ->get();

                $visible_title = true;
            }
            echo view('replay.components.search', compact('replaysSearch', 'visible_title'));
        }
    }

    public function searchReplayQuery()
    {
        $query = $this->replayQuery();
        $this->searchReplayColumn($query);

        return $query;
    }

    public function replayQuery()
    {
        return Replay::with([
            'users:id,name,avatar',
            'maps:id,name',
            'firstCountries:id,flag,name',
            'secondCountries:id,flag,name',
            'firstRaces:id,title,code',
            'secondRaces:id,title,code',
        ])->withCount('comments');
    }

    public function searchReplayColumn($query)
    {
        if (request()->has('text') && request()->filled('text')) {
            $query->where(function ($que) {
                $que->orWhere('title', 'like', '%'.request('text').'%')
                    ->orWhere('content', 'like', '%'.request('text').'%');
            });
        }
        if (request()->has('first_country_id') && request()->filled('first_country_id')) {
            $query->where('first_country_id', 'like', '%'.request('first_country_id').'%');
        }
        if (request()->has('second_country_id') && request()->filled('second_country_id')) {
            $query->where('second_country_id', 'like', '%'.request('second_country_id').'%');
        }
        if (request()->has('first_race') && request()->filled('first_race')) {
            $query->where('first_race', 'like', '%'.request('first_race').'%');
        }
        if (request()->has('second_race') && request()->filled('second_race')) {
            $query->where('second_race', 'like', '%'.request('second_race').'%');
        }
        if (request()->has('map_id') && request()->filled('map_id')) {
            $query->where('map_id', 'like', '%'.request('map_id').'%');
        }
        if (request()->has('type_id') && request()->filled('type_id')) {
            $query->where('type_id', 'like', '%'.request('type_id').'%');
        }
        if (request()->has('user_replay') && request()->filled('user_replay')) {
            $query->where('user_replay', 'like', '%'.request('user_replay').'%');
        }
    }

}
