<?php

namespace App\Http\Controllers\Admin;

use AdminSection;
use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\UserGallery;
use Illuminate\Http\Request;

class UserGalleryController extends Controller
{
    public function show($id)
    {

        $columns = [
            'id',
            'user_id',
            'picture',
            'sign',
            'positive_count',
            'negative_count',
            'comments_count',
            'created_at',
        ];
        $relations = [
            'users',
            'comments',
        ];
        $userGallery = UserGallery::select($columns)->with($relations)->findOrFail($id);

        $content = view('admin.usergallery.show',
            compact('userGallery')
        );


        return AdminSection::view($content, 'Галерея');
    }

    public function comment(Request $request, $id)
    {

        $topic = UserGallery::find($id);
        $comment = new Comment([
            'user_id' => auth()->user()->id,
            'content' => $request->input('content'),
        ]);
        $topic->comments()->save($comment);

        return back();
    }

    public function deleteComment($id)
    {
        Comment::find($id)->delete();

        return back();
    }
}
