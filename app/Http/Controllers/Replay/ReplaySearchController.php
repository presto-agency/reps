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

    private function replayQuery()
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

    private function searchReplayQuery()
    {
        $query = $this->replayQuery();
        $this->searchReplayColumn($query);

        return $query;
    }

    private function searchReplayColumn($query)
    {
        if (request()->filled('text')) {
            $query->where(function ($que) {
                $que->orWhere('title', 'LIKE', '%'.request('text').'%')
                    ->orWhere('content', 'LIKE', '%'.request('text').'%');
            });
        }
        if (request()->filled('first_country_id')) {
            $query->where('first_country_id', '=', request('first_country_id'));
        }
        if (request()->filled('second_country_id')) {
            $query->where('second_country_id', '=', request('second_country_id'));
        }
        if (request()->filled('first_race')) {
            $query->where('first_race', '=', request('first_race'));
        }
        if (request()->filled('second_race')) {
            $query->where('second_race', '=', request('second_race'));
        }
        if (request()->filled('map_id')) {
            $query->where('map_id', '=', request('map_id'));
        }
        if (request()->filled('type_id')) {
            $query->where('type_id', '=', request('type_id'));
        }
        if (request()->filled('user_replay')) {
            $query->where('user_replay', '=', request('user_replay'));
        }
        if (request()->filled('vod_rep')) {
            if (request('vod_rep') == '2') {
                $query->whereNotNull('file')->where('file', '!=', '')->where('file', '!=', ' ');
            } elseif (request('vod_rep') == '1') {
                $query->whereNotNull('src_iframe')->where('src_iframe', '!=', '')->where('src_iframe', '!=', ' ');
            }
        }
    }

}
