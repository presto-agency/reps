<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\ForumSection;
use App\Models\ForumTopic;
use Auth;
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
        //
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $topic = ForumTopic::with('author','comments')->where('id', $id)->withCount('comments')->first();

        return view('forum.topic')->with('topic', $topic);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function comment_send(Request $request, $id)
    {
        $topic = ForumTopic::find($id);
        $comment = new Comment([
            'user_id' => auth()->user()->id,
            'content' => $request->input('content')
        ]);
        $topic->comments()->save($comment);
        return back();
    }

    public function getUserTopic($user_id = 0)
    {
        if ($user_id == 0){
            $user_id = Auth::id();
        }

        $data = ForumSection::getUserTopics($user_id);//TODO: remove

        return view('user.forum.my_topics')->with([
            'topics' => $data, //TODO: remove
            'user_id' => $user_id]);
    }
}
