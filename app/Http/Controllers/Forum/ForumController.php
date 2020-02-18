<?php

namespace App\Http\Controllers\Forum;

use App\Http\Controllers\Controller;
use App\Models\ForumSection;
use Illuminate\Http\Request;

class ForumController extends Controller
{

    public function index()
    {
        return view('forum.index');
    }

    public function show($id)
    {
        return view('forum.section-show');
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

    public function loadForumShow()
    {
        if (request()->ajax()) {
            $visible_title = false;
            if (request('id') > 0) {
                $section = ForumSection::query()->withCount('topics')
                    ->with([
                        'topics' => function ($query) {
                            $query->orderByDesc('id')->where('id', '<', request('id'))
                                ->withCount('comments')
                                ->where('hide', false)
                                ->limit(7);
                        },
                        'topics.author:id,name,avatar',
                    ])->where('is_active', true)
                    ->where('id', request('forum'))
                    ->first();
            } else {
                $section       = ForumSection::query()->withCount('topics')
                    ->with([
                        'topics' => function ($query) {
                            $query->orderByDesc('id')
                                ->where('hide', false)
                                ->withCount('comments')
                                ->limit(7);
                        },
                        'topics.author:id,name,avatar',
                    ])->where('is_active', true)
                    ->where('id', request('forum'))
                    ->first();
                $visible_title = true;
            }
            if ( ! empty($section)) {
                if ($section->bot === 0) {
                    echo view('forum.components.section-show', compact('section', 'visible_title'));
                } else {
                    echo $section->bot_script;
                }
            }
        }
    }

    public function loadForumIndex()
    {
        if (request()->ajax()) {
            if (request('id') > 0) {
                $sections = ForumSection::query()->orderBy('position')
                    ->withCount('forumSectionComments')
                    ->withCount('topics')
                    ->where('position', '>', request('id'))
                    ->where('is_active', true)
                    ->limit(7)
                    ->get();
            } else {
                $sections = ForumSection::query()->orderBy('position')
                    ->withCount('forumSectionComments')
                    ->withCount('topics')
                    ->where('is_active', true)
                    ->limit(7)
                    ->get();
            }


            echo view('forum.components.index', compact('sections'));
        }
    }

}
