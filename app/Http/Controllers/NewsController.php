<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\ForumTopic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
//        $news = ForumTopic::with('author')->where('news', 1)->latest()->get();
//        return view('news.index', ['news' => $news]);
        return view('news.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        /*ForumTopic::where('id', $id)
            ->where(function ($q) {
                $q->whereNull('start_on')
                    ->orWhere('start_on', '<=', Carbon::now()->format('Y-m-d'));
            })
            ->with(User::getUserWithReputationQuery())
            ->withCount('positive', 'negative', 'comments')
            ->with('icon')->first();*/

//        $topic = ForumTopic::with('author')->where('news', 1)->latest()->get();
//        $topic = ForumTopic::where('id', $id)->first();
        $topics = ForumTopic::withCount('comments')->where('id', $id)->first();
        $count = $topics->comments()->count();
//        $topics = ForumTopic::find($id);

        /*foreach ($topics as $topic) {
            dump($topic->comments_count);
        }*/
        return view('news.show');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function load_news(Request $request)
    {
        if ($request->ajax()) {
            $visible_title = false;
            if ($request->id > 0) {
                $data = ForumTopic::with('author')
                    ->withCount('comments')
                    ->where('id', '<', $request->id)
                    ->orderBy('id', 'DESC')
                    ->limit(5)
                    ->get();
            } else {
                $data = ForumTopic::with('author')
                    ->orderBy('id', 'DESC')
                    ->limit(5)
                    ->get();
                $visible_title = true;
            }

            $output = view('news.last_news', ['news' => $data, 'visible_title' => $visible_title]);
            echo $output;
        }
    }
}
