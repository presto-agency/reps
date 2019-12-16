<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserTopicsStoreRequest;
use App\Http\Requests\UserTopicsUpdateRequest;
use App\Models\ForumSection;
use App\Models\ForumTopic;
use App\Services\ServiceAssistants\PathHelper;
use Carbon\Carbon;

class UserTopicsController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param $id
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index($id)
    {
        $forumSections = ForumSection::orderByDesc('id')->withCount([
            'topics' => function ($q) use ($id) {
                $q->where('user_id', $id);
            },
        ])->get();

        return view('user.topics.index', compact('forumSections'));
    }

    /**
     * @param $id
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function forumSectionsTopicsAjaxLoad($id)
    {
        if (request()->ajax()) {
            $visible_title = false;
            if (request('topic_id') > 0) {
                $forumSectionsTopics = ForumTopic::where('forum_section_id', request('forum_section_id'))
                                                 ->with('forumSection')
                                                 ->where('user_id', $id)
                                                 ->where('id', '<', request('topic_id'))
                                                 ->orderByDesc('id')
                                                 ->limit(10)
                                                 ->get();
            } else {
                $forumSectionsTopics = ForumTopic::where('forum_section_id', request('forum_section_id'))
                                                 ->with('forumSection')
                                                 ->where('user_id', $id)
                                                 ->orderByDesc('id')
                                                 ->limit(10)
                                                 ->get();
                $visible_title       = true;
            }

            return view('user.topics.components.components.topics-in-sections',
                compact('forumSectionsTopics', 'visible_title')
            );
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param $id
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create($id)
    {
        $forumSection = ForumSection::where('is_active', 1)
                                    ->where('user_can_add_topics', 1)
                                    ->get(
                                        [
                                            'id',
                                            'title',
                                            'description',
                                        ]
                                    );

        return view('user.topics.create', compact('forumSection'));
    }

    /**
     * @param  \App\Http\Requests\UserTopicsStoreRequest  $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(UserTopicsStoreRequest $request)
    {
        $title           = clean($request->title);
        $content         = clean($request->get('content'));
        $preview_content = clean($request->preview_content);

        if (empty($title)) {
            return back();
        }
        if (empty($content)) {
            return back();
        }
        if (empty($preview_content)) {
            return back();
        }

        $check = ForumSection::find($request->forum_section_id)->value('user_can_add_topics');
        if (auth()->user()->roles->name == 'user' && $check == 0) {
            return redirect()->to('/');
        }
        $topic                   = new ForumTopic;
        $topic->forum_section_id = $request->forum_section_id;
        $topic->title            = $title;
        $topic->preview_content  = $preview_content;
        $topic->content          = $content;
        $this->checkImg($request, $topic);
        $topic->user_id  = auth()->id();
        $topic->start_on = Carbon::now();
        $topic->save();

        return redirect()->to(route('topic.show', ['topic' => $topic->id]));
    }

    /**
     * @param $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function show($id)
    {
        return redirect()->to('/');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param $id
     * @param $user_topic
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id, $user_topic)
    {
        $forumSection = ForumSection::get([
            'id',
            'title',
            'description',
        ]);

        $topic = ForumTopic::findOrFail($user_topic);

        return view('user.topics.edit', compact('forumSection', 'topic'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UserTopicsUpdateRequest  $request
     * @param $id
     * @param $user_topic
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UserTopicsUpdateRequest $request, $id, $user_topic)
    {
        $title           = clean($request->title);
        $content         = clean($request->get('content'));
        $preview_content = clean($request->preview_content);

        if (empty($title)) {
            return back();
        }
        if (empty($content)) {
            return back();
        }
        if (empty($preview_content)) {
            return back();
        }

        $topic                   = ForumTopic::find($user_topic);
        $topic->title            = $title;
        $topic->forum_section_id = $request->forum_section_id;
        $topic->preview_content  = $preview_content;
        $topic->content          = $content;
        $this->checkImg($request, $topic);
        $topic->save();

        return redirect()->to(route('topic.show', ['topic' => $topic->id]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        return redirect()->to('/');
    }

    /**
     * @param $request
     * @param $topic
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function checkImg($request, $topic)
    {
        // Check have upload file
        if ($request->hasFile('preview_img')) {
            // Check if upload file Successful Uploads
            if ($request->file('preview_img')->isValid()) {
                // Check path and old file
                PathHelper::checkUploadsFileAndPath('/topics/images', $topic->preview_img);
                // Upload file on server
                $image              = $request->file('preview_img');
                $filePath           = $image->store('topics/images', 'public');
                $topic->preview_img = 'storage/'.$filePath;
            } else {
                return null;
            }
        }

        return null;
    }

}
