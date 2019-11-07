<?php

namespace App\Http\Controllers\User;

use App\Http\Requests\UserTopicsRequest;
use App\Models\ForumSection;
use App\Models\ForumTopic;
use App\Services\ServiceAssistants\PathHelper;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
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
        $forumSection = ForumSection::where('is_active', 1)->where('user_can_add_topics', 1)->get(['id', 'title', 'description']);

        return view('user.topics.create', compact('forumSection'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param UserTopicsRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(UserTopicsRequest $request)
    {

        $data = new ForumTopic;
        $data->forum_section_id = $request->get('forum_section_id');
        $data->title = $request->get('title');
        $data->preview_content = $request->get('preview_content');
        $data->content = $request->get('content');
        // Check have upload file
        if ($request->hasFile('preview_img')) {
            // Check if upload file Successful Uploads
            if ($request->file('preview_img')->isValid()) {
                // Check path
                PathHelper::checkUploadStoragePath("topic/image");
                // Upload file on server
                $image = $request->file('preview_img');
                $filePath = $image->store('topic/image', 'public');
                $data->preview_img = 'storage/' . $filePath;
            } else {
                back();
            }
        } else {
            back();
        }

        $data->user_id = auth()->id();
        $data->start_on = Carbon::now();
        $data->save();
        return back();

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
}
