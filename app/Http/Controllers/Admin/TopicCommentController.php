<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\ForumTopic;
use Illuminate\Http\Request;

class TopicCommentController extends Controller
{

    public function store(Request $request, $id)
    {
        $topic   = ForumTopic::query()->findOrFail($id);
        $comment = new Comment([
            'user_id' => auth()->id(),
            'content' => $request->input('content'),
        ]);
        $topic->comments()->save($comment);

        /*$content = view('admin.forum.topic.show', ['topic' => $topic]);
        return AdminSection::view($content, 'Темы форума');*/

        return back();
    }

    public function deleteComment($id)
    {
        Comment::query()->where('id', $id)->delete();

        return back();
    }
}
