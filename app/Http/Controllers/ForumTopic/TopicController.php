<?php

namespace App\Http\Controllers\ForumTopic;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\ForumTopic;
use Illuminate\Http\Request;

class TopicController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return redirect()->to('/');
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return redirect()->to('/');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $topic = ForumTopic::with(
            'author',
            'author.countries:id,name,flag',
            'author.races:id,title',
            'comments'
        )
            ->with(['author' =>function ($query){
                $query->withCount('comments');
            }])
            ->where('id', $id)->withCount('comments')->first();
        return view('forumTopic.show')->with('topic', $topic);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return redirect()->to('/');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        return redirect()->to('/');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return redirect()->to('/');
    }

    public function saveComments()
    {
        $replay = ForumTopic::find(request('id'));
        $comment = new Comment([
            'user_id' => auth()->id(),
            'content' => request('content'),
        ]);
        $replay->comments()->save($comment);
        return back();
    }


//    public function getUserTopic($user_id = 0)
//    {
////        if ($user_id == 0){
////            $user_id = Auth::id();
////        }
////
////        $data = ForumSection::getUserTopics($user_id);//TODO: remove
////
////        return view('user.forum.my_topics')->with([
////            'topics' => $data, //TODO: remove
////            'user_id' => $user_id]);
//    }
}
