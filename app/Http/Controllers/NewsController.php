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
            'author',
            'author.countries:id,name,flag',
            'author.races:id,title',
            'author'        => function ($query) {
                $query->withCount('comments');
            },
            'comments',
            'comments.user:id,avatar,name,country_id,race_id,rating,count_negative,count_positive',
            'comments.user.countries:id,name,flag',
            'comments.user.races:id,title',
            'comments.user' => function ($query) {
                $query->withCount('comments');
            },
        ])->withCount('comments')->findOrFail($id);

        event('topicHasViewed', $news);

        return view('news.show', compact('news'));
    }

    public function load_news(Request $request)
    {
        if ($request->ajax()) {
            $visible_title = false;
            if ($request->id > 0) {
                $data = ForumTopic::with('author:id,avatar,name')
                    ->withCount('comments')
                    ->where('news', true)
                    ->where('id', '<', $request->id)
                    ->orderByDesc('id')
                    ->limit(5)
                    ->get();
            } else {
                $data          = ForumTopic::with('author:id,avatar,name')
                    ->withCount('comments')
                    ->where('news', true)
                    ->orderByDesc('id')
                    ->limit(5)
                    ->get();
                $visible_title = true;
            }

            $output = view('news.components.index', [
                'news'          => $data,
                'visible_title' => $visible_title,
            ]);
            echo $output;
        }
    }

}
