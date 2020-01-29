<?php

namespace App\Http\Controllers\Search;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\ForumTopic;
use App\Models\Replay;

class SearchController extends Controller
{

    public function index()
    {
        return view('search.index');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function loadNews()
    {
        if (request()->ajax()) {
            $visible_title = false;
            if (request('id') > 0) {
                $news = $this->newsWithId();
            } else {
                $news          = $this->news();
                $visible_title = true;
            }

            return view('search.components.news-search', compact('news', 'visible_title'));
        }

        return \Response::json([], 200);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function loadReplay()
    {
        if (request()->ajax()) {
            $visible_title = false;
            if (request('id') > 0) {
                $replay = $this->replayWithId();
            } else {
                $replay        = $this->replay();
                $visible_title = true;
            }

            return view('search.components.replays-search', compact('replay', 'visible_title'));
        }

        return \Response::json([], 200);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function loadTopics()
    {
        if (request()->ajax()) {
            $visible_title = false;
            if (request('id') > 0) {
                $topics = $this->topicsWithId();
            } else {
                $topics        = $this->topics();
                $visible_title = true;
            }

            return view('search.components.topics-search', compact('topics', 'visible_title'));
        }

        return \Response::json([], 200);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function loadComments()
    {
        if (request()->ajax()) {
            $visible_title = false;
            if (request('id') > 0) {
                $comments = $this->commentsWithId();
            } else {
                $comments      = $this->comments();
                $visible_title = true;
            }

            return view('search.components.comments-search', compact('comments', 'visible_title'));
        }

        return \Response::json([], 200);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    private function news()
    {
        return ForumTopic::with('author:id,avatar,name')->withCount('comments')
            ->where('title', 'like', '%'.request('search').'%')
            ->where('news', true)
            ->orderByDesc('id')
            ->limit(5)
            ->get();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    private function newsWithId()
    {
        return ForumTopic::with('author:id,avatar,name')->withCount('comments')
            ->where('title', 'like', '%'.request('search').'%')
            ->where('id', '<', request('id'))
            ->where('news', true)
            ->orderByDesc('id')
            ->limit(5)
            ->get();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    private function replay()
    {
        return Replay::with([
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
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    private function replayWithId()
    {
        return Replay::with([
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
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    private function topics()
    {
        return ForumTopic::with('author:id,avatar,name')->withCount('comments')
            ->where('title', 'like', '%'.request('search').'%')
            ->where('news', false)
            ->orderByDesc('id')
            ->limit(5)
            ->get();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    private function topicsWithId()
    {
        return ForumTopic::with('author:id,avatar,name')->withCount('comments')
            ->where('title', 'like', '%'.request('search').'%')
            ->where('id', '<', request('id'))
            ->where('news', false)
            ->orderByDesc('id')
            ->limit(5)
            ->get();
    }

    private function comments()
    {
        return Comment::with([
            'user',
            'user.countries:id,name,flag',
            'user.races:id,title',
            'user' => function ($query) {
                $query->withCount('comments');
            },
        ])
            ->where('content', 'like', '%'.request('search').'%')
            ->whereNotNull('user_id')
            ->orderByDesc('id')
            ->limit(5)
            ->get();
    }


    private function commentsWithId()
    {
        return Comment::with([
            'user',
            'user.countries:id,name,flag',
            'user.races:id,title',
            'user' => function ($query) {
                $query->withCount('comments');
            },
        ])
            ->where('content', 'like', '%'.request('search').'%')
            ->where('id', '<', request('id'))
            ->whereNotNull('user_id')
            ->orderByDesc('id')
            ->limit(5)
            ->get();
    }

}
