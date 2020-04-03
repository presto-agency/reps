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

        $userGallery = UserGallery::with(['users', 'comments','comments.user'])->findOrFail($id);

        $content = view('admin.usergallery.show', compact('userGallery'));

        return AdminSection::view($content, 'Галерея');
    }

    public function comment(Request $request, $id)
    {

        $topic   = UserGallery::query()->findOrFail($id);
        $comment = new Comment([
            'user_id' => auth()->id(),
            'content' => $request->input('content'),
        ]);
        $topic->comments()->save($comment);

        return back();
    }

    public function deleteComment($id)
    {
        Comment::query()->where('id',$id)->delete();

        return back();
    }

}
