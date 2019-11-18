<?php

namespace App\Http\Controllers;

use App\Models\ForumTopic;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('news.index');
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
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $news = ForumTopic::with(

            'author',
            'author.countries:id,name,flag',
            'author.races:id,title',

            'comments',
            'comments.user:id,avatar,name,country_id,race_id,rating,count_negative,count_positive',
            'comments.user.countries:id,name,flag',
            'comments.user.races:id,title'
        )
            ->with(['author' => function ($query) {
                $query->withCount('comments');
            }])
            ->with(['comments.user' => function ($query) {
                $query->withCount('comments');
            }])
            ->findOrFail($id);


        event('topicHasViewed', $news);
        $bbcode = new \ChrisKonnertz\BBCode\BBCode();
        $bbcode->ignoreTag('size');

        $data = null;
        $data['preview_content'] = $bbcode->render($news->preview_content);
        $data['content'] = $bbcode->render($news->content);

        return view('news.show', compact('news', 'data'));
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
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
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

    public function load_news(Request $request)
    {
        if ($request->ajax()) {
            $visible_title = false;
            if ($request->id > 0) {
                $data = ForumTopic::with('author:id,avatar,name')
                    ->withCount('comments')
                    ->where('id', '<', $request->id)
                    ->orderByDesc('id')
                    ->limit(5)
                    ->get();
            } else {
                $data = ForumTopic::with('author:id,avatar,name')
                    ->withCount('comments')
                    ->orderByDesc('id')
                    ->limit(5)
                    ->get();
                $visible_title = true;
            }

            $output = view('news.components.index', [
                'news'          => $data,
                'visible_title' => $visible_title
            ]);
            echo $output;
        }
    }

}
