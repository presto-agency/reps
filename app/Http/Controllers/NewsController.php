<?php

namespace App\Http\Controllers;

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
                $query->select(['id', 'avatar', 'name', 'country_id', 'race_id', 'rating', 'count_negative', 'count_positive', 'gas_balance',])
                    ->withCount('comments');
            },
            'author.countries:id,name,flag',
            'author.races:id,title',

            'comments',
            'comments.user.countries:id,name,flag',
            'comments.user.races:id,title',
            'comments.user' => function ($query) {
                $query->select(['id', 'avatar', 'name', 'country_id', 'race_id', 'rating', 'count_negative', 'count_positive', 'gas_balance',])
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
            $fixingNews    = collect();
            if ($request->id > 0) {
                $news = $this->newsWithId($request);
            } else {
                $news       = $this->news();
                $fixingNews = $this->fixingNews();
                /*if ($fixingNews->isNotEmpty() && $news->isNotEmpty()) {
                    foreach ($news as $items) {
                        $id         = $items->id;
                        $fixingNews = $fixingNews->filter(function ($item) use ($id) {
                            return $item->id != $id;
                        });
                    }
                }*/
                $visible_title = true;
            }

            return view('news.components.index', compact('news', 'fixingNews', 'visible_title'));
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
            ->where('hide', 0)
            ->where('news', 1)
            ->where('fixing', 0)
            ->withCount('comments')
            ->orderByDesc('id')
            ->limit(5)
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
            ->where('hide', 0)
            ->where('news', 1)
            ->where('fixing', 0)
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
            ->where('hide', 0)
            ->where('fixing', 1)
            ->where('news', 1)
            ->withCount('comments')
            ->orderByDesc('id')
            ->limit(100)
            ->get();
    }

}
