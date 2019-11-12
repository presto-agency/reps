<?php

namespace App\Http\Controllers\User;

use App\Http\Requests\UserTopicsStoreRequest;
use App\Http\Requests\UserTopicsUpdateRequest;
use App\Models\ForumSection;
use App\Models\ForumTopic;
use App\Services\ServiceAssistants\PathHelper;
use App\User;
use Carbon\Carbon;
use App\Http\Controllers\Controller;

class UserTopicsController extends Controller
{


    /**
     * Display a listing of the resource.
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        User::findOrFail(\request('id'));
        $topics = ForumSection::with('topics.forumSection')
            ->with(['topics' => function ($query) use ($id) {
                $query->where('user_id', $id);
                $query->withCount('comments');
            }])
            ->get();

        return view('user.topics.index', compact('topics'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $forumSection = ForumSection::where('is_active', 1)
            ->where('user_can_add_topics', 1)
            ->get(['id', 'title', 'description']);

        return view('user.topics.create', compact('forumSection'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param UserTopicsStoreRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(UserTopicsStoreRequest $request)
    {

        $topic = new ForumTopic;
        $topic->forum_section_id = $request->get('forum_section_id');
        $topic->title = $request->get('title');
        $topic->preview_content = $request->get('preview_content');
        $topic->content = $request->get('content');
        $this->checkImg($request, $topic);
        $topic->user_id = auth()->id();
        $topic->start_on = Carbon::now();
        $topic->save();
        return redirect()->to(route('topic.show', ['topic' => $topic->id]));

    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return redirect()->to('/');

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @param int $user_topic
     * @return \Illuminate\Http\Response
     */
    public function edit($id, $user_topic)
    {
        $forumSection = ForumSection::where('is_active', 1)
            ->where('user_can_add_topics', 1)
            ->get(['id', 'title', 'description']);

        $topic = ForumTopic::where('id', $user_topic)->where('user_id', $id)->firstOrFail();

        return view('user.topics.edit', compact('forumSection', 'topic'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UserTopicsUpdateRequest $request
     * @param int $id
     * @param int $user_topic
     * @return \Illuminate\Http\Response
     */
    public function update(UserTopicsUpdateRequest $request, $id, $user_topic)
    {
        $topic = ForumTopic::where('id', $user_topic)->firstOrFail();
        $topic->title = $request->get('title');
        $topic->forum_section_id = $request->get('forum_section_id');
        $topic->preview_content = $request->get('preview_content');
        $topic->content = $request->get('content');
        $this->checkImg($request, $topic);
        $topic->save();
        return redirect()->to(route('topic.show', ['topic' => $topic->id]));
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

    public function checkImg($request, $topic)
    {
        // Check have upload file
        if ($request->hasFile('preview_img')) {
            // Check if upload file Successful Uploads
            if ($request->file('preview_img')->isValid()) {
                // Check path
                PathHelper::checkUploadStoragePath("topic/image");
                // Check old file
                PathHelper::checkFileAndDelete($topic->preview_img);
                // Upload file on server
                $image = $request->file('preview_img');
                $filePath = $image->store('topic/image', 'public');
                $topic->preview_img = 'storage/' . $filePath;
            } else {
                back();
            }
        } else {
            back();
        }
    }
}
