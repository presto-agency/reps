<?php

namespace App\Http\Controllers\User;

use App\Models\Comment;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserCommentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $comments = self::getUserComments();

        return view('user.comments.index', compact('comments'));
    }

    /**
     * @return mixed
     */
    private static function getUserComments()
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
        $data = Comment::where('user_id', auth()->id())->get($columns);
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
        return $comments;
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
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
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
            'created_at' => $item->created_at->format('h:m d.m.y'),
            'route' => $route,
        ];
    }

    private static function convertModelClassName($full_class_name)
    {
        $prepareData = explode('\\', $full_class_name);
        $modalName = end($prepareData);

        switch ($modalName) {
            case 'Replay':
                return 'Реплеи';
                break;
            case 'UserGallery':
                return 'Галерея';
                break;
            case 'ForumTopic':
                return 'Форум';
                break;
            default:
                return null;
                break;
        }
    }
}
