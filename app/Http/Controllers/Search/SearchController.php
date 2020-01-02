<?php

namespace App\Http\Controllers\Search;

use App\Http\Controllers\Controller;
use App\Models\ForumTopic;
use App\Models\Replay;

class SearchController extends Controller
{

    public function index()
    {
        return view('search.index');
    }

    public function loadNews()
    {
        if (request()->ajax()) {
            $visible_title = false;
            if (request('id') > 0) {
                $news = ForumTopic::with('author:id,avatar,name')->withCount('comments')
                    ->where('title', 'like', '%'.request('search').'%')
                    ->where('id', '<', request('id'))
                    ->where('news', true)
                    ->orderByDesc('id')
                    ->limit(5)
                    ->get();
            } else {
                $news          = ForumTopic::with('author:id,avatar,name')->withCount('comments')
                    ->where('title', 'like', '%'.request('search').'%')
                    ->where('news', true)
                    ->orderByDesc('id')
                    ->limit(5)
                    ->get();
                $visible_title = true;
            }
            echo view('search.components.news-search', compact('news', 'visible_title'));
        }
    }

    public function loadReplay()
    {
        if (request()->ajax()) {
            $visible_title = false;
            if (request('id') > 0) {
                $replay = Replay::with([
                    'users:id,name,avatar',
                    'maps:id,name',
                    'firstCountries:id,flag,name',
                    'secondCountries:id,flag,name',
                    'firstRaces:id,title,code',
                    'secondRaces:id,title,code',
                ])->where('title', 'like', '%'.request('search').'%')
                    ->withCount('comments')
                    ->where('id', '<', request('id'))
                    ->orderByDesc('id')
                    ->limit(5)
                    ->get();
            } else {
                $replay = Replay::with([
                    'users:id,name,avatar',
                    'maps:id,name',
                    'firstCountries:id,flag,name',
                    'secondCountries:id,flag,name',
                    'firstRaces:id,title,code',
                    'secondRaces:id,title,code',
                ])->where('title', 'like', '%'.request('search').'%')
                    ->withCount('comments')
                    ->orderByDesc('id')
                    ->limit(5)
                    ->get();

                $visible_title = true;
            }
            echo view('search.components.replays-search', compact('replay', 'visible_title'));
        }
    }


}
