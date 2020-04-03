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

        $topic   = ForumTopic::with([
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

        ])->withCount('comments', 'positive', 'negative')->findOrFail($id);
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
