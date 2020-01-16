<?php

namespace App\Http\Controllers\Admin;

use AdminSection;
use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\ForumTopic;

class ForumTopicController extends Controller
{

    public function show($id)
    {

        $topic   = ForumTopic::find($id);
        $content = view('admin.forum.topic.show', ['topic' => $topic]);

        return AdminSection::view($content, 'Темы форума');
    }

//    public function deleteComment($id)
//    {
//        Comment::find($id)->delete();
//
//        return back();
//    }
}
