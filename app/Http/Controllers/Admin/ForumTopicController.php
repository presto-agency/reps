<?php

namespace App\Http\Controllers\Admin;

use AdminSection;
use App\Models\ForumTopic;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ForumTopicController extends Controller
{
    public function show($id){

        $topic = ForumTopic::find($id);
        $content = view('admin.forum.topic.show', ['topic' => $topic]);
        return AdminSection::view($content, 'Темы форума');
    }
}
