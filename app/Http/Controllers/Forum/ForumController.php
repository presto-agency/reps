<?php

namespace App\Http\Controllers\Forum;

use App\Http\Controllers\Controller;
use App\Models\ForumSection;
use Illuminate\Http\Request;

class ForumController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('forum.index');
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
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
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
        return view('forum.section-show');
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

    public function loadForumShow()
    {
        if (request()->ajax()) {
            $visible_title = false;
            if (request('id') > 0) {
                $section = ForumSection::withCount('topics')
                    ->with(['topics' => function ($query) {
                        $query->orderByDesc('id')
                            ->where('id','<', request('id'))
                            ->withCount('comments')
                            ->limit(5);
                    }, 'topics.author:id,name,avatar'])
                    ->where('id', request('forum'))
                    ->first();

                $commentTopic = [];
                $commentTopicCount = null;

                if (!$section->topics->isEmpty()) {
                    foreach ($section->topics as $item) {
                        $commentTopic[] = [
                            'comments_count' => $item->comments_count
                        ];
                        $commentTopicCount = collect($commentTopic)->sum('comments_count');
                    }
                    $section->setAttribute('topics_comments_count', $commentTopicCount);
                }
            } else {
                $section = ForumSection::withCount('topics')
                    ->with(['topics' => function ($query) {
                        $query->orderByDesc('id')
                            ->withCount('comments')
                            ->limit(5);
                    }, 'topics.author:id,name,avatar'])
                    ->where('id', request('forum'))
                    ->first();


                $commentTopic = [];
                $commentTopicCount = null;
                if (!$section->topics->isEmpty()) {
                    foreach ($section->topics as $item) {
                        $commentTopic[] = [
                            'comments_count' => $item->comments_count
                        ];
                        $commentTopicCount = collect($commentTopic)->sum('comments_count');
                    }
                    $section->setAttribute('topics_comments_count', $commentTopicCount);
                }
                $visible_title = true;
            }
            echo view('forum.components.section-show', compact('section', 'visible_title'));
        }
    }

    public function loadForumIndex()
    {
        if (request()->ajax()) {
            if (request('id') > 0) {
                $sections = ForumSection::orderByDesc('id')
                    ->with(['topics' => function ($query) {
                        $query->withCount('comments');
                    }])
                    ->withCount('topics')
                    ->where('id', '<', request('id'))
                    ->limit(5)
                    ->get();
                foreach ($sections as $section) {
                    $section->section_comments_count = $section->topics->sum('comments_count');
                }
            } else {
                $sections = ForumSection::orderByDesc('id')
                    ->with(['topics' => function ($query) {
                        $query->withCount('comments');
                    }])
                    ->withCount('topics')
                    ->limit(5)
                    ->get();

                foreach ($sections as $section) {
                    $section->section_comments_count = $section->topics->sum('comments_count');
                }
            }
            echo view('forum.components.index', compact('sections'));
        }
    }
}
