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

        return \Response::json([], 404);
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

        return \Response::json([], 404);
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

        return \Response::json([], 404);
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

        return \Response::json([], 404);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    private function news()
    {
        return ForumTopic::with('author')
            ->where('title', 'like', '%'.request('search').'%')
            ->select(['id', 'title', 'preview_img', 'preview_content', 'reviews', 'user_id', 'news', 'created_at',])
            ->where('news', true)
            ->where('hide', false)
            ->where('fixing', false)
            ->where('important', false)
            ->withCount('comments')
            ->orderByDesc('id')
            ->limit(5)
            ->get();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    private function newsWithId()
    {
        return ForumTopic::with('author')
            ->where('title', 'like', '%'.request('search').'%')
            ->select(['id', 'title', 'preview_img', 'preview_content', 'reviews', 'user_id', 'news', 'created_at',])
            ->where('id', '<', request('id'))
            ->where('news', true)
            ->where('hide', false)
            ->where('fixing', false)
            ->where('important', false)
            ->withCount('comments')
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
        ])->select([
            'id', 'title', 'user_id', 'map_id', 'file', 'downloaded', 'content',
            'first_country_id', 'second_country_id', 'first_race', 'second_race',
            'user_replay', 'rating', 'created_at',
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
        ])->select([
            'id', 'title', 'user_id', 'map_id', 'file', 'downloaded', 'content', 'first_country_id',
            'second_country_id', 'first_race', 'second_race', 'user_replay', 'rating', 'created_at',
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
        return ForumTopic::with('author')
            ->where('title', 'like', '%'.request('search').'%')
            ->select(['id', 'title', 'reviews', 'user_id', 'news', 'created_at',])
            ->where('news', false)
            ->where('hide', false)
            ->withCount('comments')
            ->orderByDesc('id')
            ->limit(5)
            ->get();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    private function topicsWithId()
    {
        return ForumTopic::with('author')
            ->where('title', 'like', '%'.request('search').'%')
            ->select(['id', 'title', 'reviews', 'user_id', 'news', 'created_at',])
            ->where('id', '<', request('id'))
            ->where('news', false)
            ->where('hide', false)
            ->withCount('comments')
            ->orderByDesc('id')
            ->limit(5)
            ->get();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Query\Builder[]|\Illuminate\Support\Collection
     */
    private function comments()
    {
        return Comment::with([
            'user' => function ($query) {
                $query->withCount('comments');
            },
            'user.countries:id,name,flag',
            'user.races:id,title',
        ])->select(['id', 'user_id', 'commentable_id', 'commentable_type', 'content', 'negative_count', 'positive_count', 'created_at'])
            ->where('content', 'like', '%'.request('search').'%')
            ->whereNotNull('user_id')
            ->orderByDesc('id')
            ->limit(5)
            ->get();
    }


    /**
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Query\Builder[]|\Illuminate\Support\Collection
     */
    private function commentsWithId()
    {
        return Comment::with([
            'user' => function ($query) {
                $query->withCount('comments');
            },
            'user.countries:id,name,flag',
            'user.races:id,title',
        ])->select(['id', 'user_id', 'commentable_id', 'commentable_type', 'content', 'negative_count', 'positive_count', 'created_at'])
            ->where('content', 'like', '%'.request('search').'%')
            ->where('id', '<', request('id'))
            ->whereNotNull('user_id')
            ->orderByDesc('id')
            ->limit(5)
            ->get();
    }

}
