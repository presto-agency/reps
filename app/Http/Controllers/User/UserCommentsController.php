<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\User;
use Illuminate\Http\Request;

class UserCommentsController extends Controller
{

    /**
     * @param $id
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index($id)
    {
        $sections = User::$sections;
        return view('user.comments.index', compact('sections'));
    }


    /**
     * @param  \Request  $request
     * @param $id
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function forumSectionsCommentsAjaxLoad($id)
    {
        $request = request();

        if ($request->ajax()) {
            $visible_title = false;
            if ($request->get('comment_id') > 0) {
                $comments = Comment::orderByDesc('id')
                                   ->where('commentable_type', self::getCommentTableType($request->relation_id))
                                   ->where('id', '<', $request->get('comment_id'))
                                   ->where('user_id', $id)
                                   ->limit(5)
                                   ->get();
            } else {
                $comments      = Comment::orderByDesc('id')
                                        ->where('commentable_type', self::getCommentTableType($request->relation_id))
                                        ->where('user_id', $id)
                                        ->limit(5)
                                        ->get();
                $visible_title = true;
            }

            return view('user.comments.components.components.comments-in-sections',
                compact('comments', 'visible_title')
            );
        }
    }
    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function create()
    {
        return redirect()->to('/');
    }

    /**
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        return redirect()->to('/');
    }

    /**
     * @param $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function show($id)
    {
        return redirect()->to('/');
    }

    /**
     * @param $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function edit($id)
    {
        return redirect()->to('/');
    }

    /**
     * @param  \Illuminate\Http\Request  $request
     * @param $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        return redirect()->to('/');
    }

    /**
     * @param $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        return redirect()->to('/');
    }

    /**
     * @param $relation_id
     *
     * @return string|null
     */
    public static function getCommentTableType($relation_id)
    {
        switch ((int) $relation_id) {
            case User::REPLAY:
                return Comment::RELATION_REPLAY;
                break;
            case User::GALLERY:
                return Comment::RELATION_USER_GALLERY;
                break;
            case User::TOPICS:
                return Comment::RELATION_FORUM_TOPIC;
                break;
            default:
                return null;
                break;
        }
    }

}
