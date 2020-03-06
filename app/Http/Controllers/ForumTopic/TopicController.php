<?php

namespace App\Http\Controllers\ForumTopic;

use App\Http\Controllers\Controller;
use App\Http\Requests\CommentsStoreRequests;
use App\Models\Comment;
use App\Models\ForumTopic;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TopicController extends Controller
{

    public function index()
    {
        return abort(404);
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

    /**
     * @param $id
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($id)
    {
        $topic = ForumTopic::with([

            'author:id,avatar,name,country_id,race_id,count_negative,count_positive,gas_balance',
            'author.countries:id,name,flag',
            'author.races:id,title',
            'author'        => function ($query) {
                $query->withCount('comments');
            },
            'comments',
            'comments.user:id,avatar,name,country_id,race_id,rating,count_negative,count_positive,gas_balance',
            'comments.user.countries:id,name,flag',
            'comments.user.races:id,title',
            'comments.user' => function ($query) {
                $query->withCount('comments');
            },

        ])->withCount('comments', 'positive', 'negative')->where('hide', false)->findOrFail($id);

        event('topicHasViewed', $topic);

        return view('forumTopic.show')->with('topic', $topic);
    }

    /**
     * @param  \App\Http\Requests\CommentsStoreRequests  $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function saveComments(CommentsStoreRequests $request)
    {
        $content = clean($request->input('content'));

        if (empty($content)) {
            return redirect()->back();
        }
        $model               = ForumTopic::query()->where('hide', false)->findOrFail($request->get('id'));
        $model->commented_at = Carbon::now();
        $model->save();

        $comment = new Comment([
            'user_id' => auth()->id(),
            'content' => $content,
        ]);

        $model->comments()->save($comment);

        return redirect()->back();
    }

}
