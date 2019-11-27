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
     * @param  $id
     * @param  $request
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        //                $user = User::findOrFail((int)$id);
//        $forumSections = ForumSection::with('topics.forumSection')
//            ->whereHas(
//                'topics', function ($query) use ($id) {
//                $query->where('user_id', $id);
//                $query->withCount('comments');
//            })->get();
        //                    $forumSections = ForumSection::findOrFail();
        //                 $request = request();
        //                $topics = $forumSections->topics()->orderBy('created_at', 'desc')
        //                    ->skip(5)->take(10)->get();
        //        //        dd($forumSections, $topics);
        //                    if($request->ajax()) {
        //                    }\
        return view('user.topics.index');
    }

    public function forumSectionsAjaxLoad($id)
    {
        if (request()->ajax()) {

            $visible_title = false;

            if (request('section_id') > 0) {

                $forumSections = ForumSection::orderByDesc('id')
                    ->where('id', '<', request('section_id'))
                    ->limit(5)
                    ->get();
            } else {
                $forumSections = ForumSection::orderByDesc('id')
                    ->limit(5)
                    ->get();
                $visible_title = true;
            }
            return view('user.topics.components.index',
                compact('forumSections', 'visible_title')
            );
        }
    }
    public function forumSectionsTopicsAjaxLoad($id)
    {


        if (request()->ajax()) {
            $visible_title = false;
            if (request('topic_id') > 0) {
                $forumSectionsTopics = ForumTopic::where('forum_section_id',request('forum_section_id'))
                    ->where('id', '<', request('topic_id'))
                    ->orderByDesc('id')
                    ->limit(10)
                    ->get();
            } else {
                $forumSectionsTopics = ForumTopic::where('forum_section_id',request('forum_section_id'))
                    ->orderByDesc('id')
                    ->limit(10)
                    ->get();
                $visible_title = true;
            }
            dump($forumSectionsTopics);
            return view('user.topics.components.components.topics-in-sections',
                compact('forumSectionsTopics', 'visible_title')
            );
        }
    }


    /**
     * Show the form for creating a new resource.
     *
     * @param  $id
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $forumSection = ForumSection::where('is_active', 1)
            ->where('user_can_add_topics', 1)
            ->get([
                'id',
                'title',
                'description',
            ]);

        return view('user.topics.create', compact('forumSection'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param UserTopicsStoreRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(UserTopicsStoreRequest $request)
    {
        $check = ForumSection::find($request->get('forum_section_id'))
            ->value('user_can_add_topics');
        if ($check != 1) {
            return redirect()->to('/');
        }
        $topic = new ForumTopic;
        $topic->forum_section_id = $request->get('forum_section_id');
        $topic->title = clean($request->get('title'));
        $topic->preview_content = clean($request->get('preview_content'));
        $topic->content = clean($request->get('content'));
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
     *
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
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id, $user_topic)
    {
        $forumSection = ForumSection::get(
            [
                'id',
                'title',
                'description',
            ]
        );

        $topic = ForumTopic::findOrFail($user_topic);

        return view('user.topics.edit', compact('forumSection', 'topic'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UserTopicsUpdateRequest $request
     * @param int $id
     * @param int $user_topic
     *
     * @return \Illuminate\Http\Response
     */
    public function update(UserTopicsUpdateRequest $request, $id, $user_topic)
    {
        $topic = ForumTopic::findOrFail($user_topic);
        $topic->title = clean($request->get('title'));
        $topic->forum_section_id = $request->get('forum_section_id');
        $topic->preview_content = clean($request->get('preview_content'));
        $topic->content = clean($request->get('content'));
        $this->checkImg($request, $topic);
        $topic->save();

        return redirect()->to(route('topic.show', ['topic' => $topic->id]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
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
                PathHelper::checkUploadsFileAndPath(
                    "/topics/images", $topic->preview_img
                );
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
