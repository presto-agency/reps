<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Admin\SettingController;
use App\Models\ForumTopic;
use Illuminate\Http\Request;

class NewsController extends Controller
{

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('news.index');
    }

    public function create()
    {
        return abort(404);
    }

    public function store(Request $request)
    {
        return abort(404);
    }

    public function edit($id)
    {
        return abort(404);
    }

    public function update(Request $request, $id)
    {
        return abort(404);
    }

    public function destroy($id)
    {
        return abort(404);
    }

    public function show($id)
    {
        $news = ForumTopic::with([
            'author'        => function ($query) {
                $query->select([
                    'id', 'avatar', 'name', 'country_id', 'race_id', 'rating', 'count_negative', 'count_positive',
                    'gas_balance',
                ])
                    ->withCount('comments');
            },
            'author.countries:id,name,flag',
            'author.races:id,title',

            'comments',
            'comments.user.countries:id,name,flag',
            'comments.user.races:id,title',
            'comments.user' => function ($query) {
                $query->select([
                    'id', 'avatar', 'name', 'country_id', 'race_id', 'rating', 'count_negative', 'count_positive',
                    'gas_balance',
                ])
                    ->withCount('comments');
            },
        ])->where('hide', false)
            ->where('news', true)->withCount('comments')->findOrFail($id);

        event('topicHasViewed', $news);

        return view('news.show', compact('news'));
    }

    public function loadNews(Request $request)
    {
        if ($request->ajax()) {
            $visible_title = false;
            $fixingNews = collect();
            if ($request->id > 0) {
                $news = $this->newsWithId($request);
            } else {
                // get last 5 fix news
                $importantNews = ForumTopic::getLastImportantNews(SettingController::countLoadImportantNews());
                $fixingNews = ForumTopic::getLastWithParamsNewsIndex(false, true, true,
                    SettingController::countLoadFixNews());

//                $newsFixCount = abs($fixingNews->count() - 5);

                // get last 10 fix news
                $news = ForumTopic::getLastWithParamsNewsIndex(false, false, true, SettingController::countLoadNews());

                $visible_title = true;
            }

            return view('news.components.index', compact('importantNews', 'fixingNews', 'news', 'visible_title'));
        }

        return \Response::json([], 404);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    private function news()
    {
        return ForumTopic::with('author:id,name,avatar')
            ->select(['id', 'title', 'preview_img', 'preview_content', 'reviews', 'user_id', 'news', 'created_at',])
            ->where('hide', false)
            ->where('news', true)
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
    private function fixingNews()
    {
        return ForumTopic::with('author:id,name,avatar')
            ->select(['id', 'title', 'preview_img', 'preview_content', 'reviews', 'user_id', 'news', 'created_at',])
            ->where('hide', false)
            ->where('fixing', true)
            ->where('news', true)
            ->where('important', false)
            ->withCount('comments')
            ->orderByDesc('id')
            ->limit(100)
            ->get();
    }

    /**
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    private function newsWithId(Request $request)
    {
        return ForumTopic::with('author:id,name,avatar')
            ->select(['id', 'title', 'preview_img', 'preview_content', 'reviews', 'user_id', 'news', 'created_at',])
            ->where('id', '<', $request->id)
            ->where('hide', false)
            ->where('fixing', false)
            ->where('news', true)
            ->where('important', false)
            ->withCount('comments')
            ->orderByDesc('id')
            ->limit(5)
            ->get();
    }


}
