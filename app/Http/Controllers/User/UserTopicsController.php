<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserTopicsStoreRequest;
use App\Http\Requests\UserTopicsUpdateRequest;
use App\Models\ForumSection;
use App\Models\ForumTopic;
use App\Services\ServiceAssistants\PathHelper;

class UserTopicsController extends Controller
{

    /**
     * @param  int  $id
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(int $id)
    {
        $forumSections = ForumSection::orderByDesc('id')->withCount([
            'topics' => function ($q) use ($id) {
                $q->where('user_id', $id);
            },
        ])->get();

        return view('user.topics.index', compact('forumSections'));
    }

    /**
     * @param  int  $id
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function forumSectionsTopicsAjaxLoad(int $id)
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
            ->get(['id', 'title', 'description',]);


        return view('user.topics.create', compact('forumSection'));
    }

    /**
     * @param  \App\Http\Requests\UserTopicsStoreRequest  $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(UserTopicsStoreRequest $request)
    {
        $title           = clean($request->get('title'));
        $preview_content = clean($request->get('preview_content'));
        $content         = clean($request->get('content'));

        if (empty($title) || empty($content) || empty($preview_content)) {
            return back();
        }

        $check = ForumSection::find($request->get('forum_section'))->value('user_can_add_topics');
        if (auth()->user()->roles->name == 'user' && $check == 0) {
            return redirect()->to('/');
        }
        $topic = new ForumTopic;
        $this->modelColumn($topic, $request, $title, $preview_content, $content);
        $topic->save();

        return redirect()->route('topic.show', ['topic' => $topic->id]);
    }

    /**
     * @param  int  $id
     * @param  int  $user_topic
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(int $id, int $user_topic)
    {
        $forumSection = ForumSection::all(['id', 'title', 'description']);

        $topic = ForumTopic::findOrFail($user_topic);

        return view('user.topics.edit', compact('forumSection', 'topic'));
    }

    /**
     * @param  \App\Http\Requests\UserTopicsUpdateRequest  $request
     * @param $id
     * @param $user_topic
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UserTopicsUpdateRequest $request, $id, $user_topic)
    {
        $title           = clean($request->get('title'));
        $preview_content = clean($request->get('preview_content'));
        $content         = clean($request->get('content'));

        if (empty($title) || empty($content) || empty($preview_content)) {
            return back();
        }

        $check = ForumSection::find($request->get('forum_section'))->value('user_can_add_topics');
        if (auth()->user()->roles->name == 'user' && $check == 0) {
            return redirect()->to('/');
        }
        $topic = new ForumTopic;
        $this->modelColumn($topic, $request, $title, $preview_content, $content);
        $topic->save();

        return redirect()->to(route('topic.show', ['topic' => $topic->id]));
    }

    /**
     * @param $topic
     * @param $request
     * @param $title
     * @param $preview_content
     * @param $content
     */
    public function modelColumn($topic, $request, $title, $preview_content, $content)
    {
        $topic->forum_section_id = $request->get('forum_section');
        $topic->title            = $title;
        $topic->preview_content  = $preview_content;
        $topic->content          = $content;
        /**
         * Upload file
         */
        if ($request->hasFile('preview_img') && $request->file('preview_img')->isValid()) {
            /**
             * Check file path and delete old
             */
            PathHelper::checkUploadsFileAndPath('/topics/images', $topic->preview_img);
            $topic->preview_img = 'storage/'.$request->file('preview_img')->store('topics/images', 'public');
        }
    }

    public function show($id)
    {
        return abort(404);
    }

    public function destroy($id)
    {
        return abort(404);
    }

}
