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
                $news = ForumTopic::with('author')
                    ->where('title', 'like', '%' . request('search') . '%')
                    ->where('id', '<', request('id'))
                    ->where('news', 1)
                    ->orderByDesc('id')
                    ->limit(5)
                    ->get();
            } else {
                $news = ForumTopic::with('author')
                    ->where('title', 'like', '%' . request('search') . '%')
                    ->where('news', 1)
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
                $replay = Replay::where('title', 'like', '%' . request('search') . '%')
                    ->where('id', '<', request('id'))
                    ->orderByDesc('id')
                    ->limit(5)
                    ->get();

            } else {
                $replay = Replay::where('title', 'like', '%' . request('search') . '%')
                    ->orderByDesc('id')
                    ->limit(5)
                    ->get();
                $visible_title = true;
            }
            echo view('search.components.replays-search', compact('replay', 'visible_title'));
        }
    }


}
