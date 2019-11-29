<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\User;
use Illuminate\Http\Request;

class UserCommentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $sections = User::$sections;
        return view('user.comments.index', compact('sections'));
    }


//    public function forumSectionsAjaxLoad()
//    {

//    }


    /**
     * @param \Request $request
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function forumSectionsCommentsAjaxLoad($id)
    {
        $request = request();

        if ($request->ajax()) {
            $visible_title = false;
            if ($request->get('comment_id') > 0) {
                $comments = Comment::orderByDesc('id')
                    ->where('commentable_type',self::getCommentTableType($request->relation_id))
                    ->where('id', '<', $request->get('comment_id'))
                    ->where('user_id', $id)
                    ->limit(5)
                    ->get();
            } else {
                $comments = Comment::orderByDesc('id')
                    ->where('commentable_type',self::getCommentTableType($request->relation_id))
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
     * @param $id
     * @return mixed
     */
    private static function getUserComments($id)
    {
        $columns = [
            'id',
            'user_id',
            'commentable_type',
            'commentable_id',
            'title',
            'content',
            'rating',
            'negative_count',
            'positive_count',
            'created_at',
        ];
        $comments = null;
        $data = Comment::where('user_id', $id)->get($columns);
        if (!$data->isEmpty()) {
            foreach ($data as $item) {
                if (self::convertModelClassName($item->commentable_type) == 'Реплеи') {
                    $route = route('replay.show', ['replay' => $item->commentable_id]);
                    $comments['Реплеи'][] = self::getData($item, $route);
                }
                if (self::convertModelClassName($item->commentable_type) == 'Галерея') {
                    $route = route('galleries.show', ['gallery' => $item->commentable_id]);
                    $comments['Галерея'][] = self::getData($item, $route);
                }
                if (self::convertModelClassName($item->commentable_type) == 'Форум') {
                    $route = route('topic.show', ['topic' => $item->commentable_id]);
                    $comments['Форум'][] = self::getData($item, $route);
                }
            }
        }

        return $comments;
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
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return redirect()->to('/');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return redirect()->to('/');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return redirect()->to('/');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        return redirect()->to('/');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return redirect()->to('/');
    }

    private static function getData($item, $route)
    {
        return [
            'id' => $item->id,
            'user_name' => auth()->user()->name,
            'user_id' => $item->user_id,
            'title' => $item->title,
            'content' => $item->content,
            'rating' => $item->rating,
            'negative_count' => $item->negative_count,
            'positive_count' => $item->positive_count,
            'created_at' => $item->created_at->format('H:i d.m.Y'),
            'route' => $route,
        ];
    }

    public static function getCommentTableType($relation_id)
    {
        switch ((int)$relation_id) {
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
