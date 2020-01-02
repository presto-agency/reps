<?php

namespace App\Http\Controllers\Gallery;

use App\Http\Controllers\Controller;
use App\Http\Requests\CommentsStoreRequests;
use App\Models\Comment;
use App\Models\UserGallery;
use Illuminate\Http\Request;

class GalleriesController extends Controller
{

    public function index()
    {
        return view('gallery.index');
    }

    public function create()
    {
        return abort(404);
    }


    public function store(Request $request)
    {
        return abort(404);
    }

    public function edit($id)
    {
        return abort(404);
    }

    public function update(Request $request, $id)
    {
        return abort(404);
    }

    public function destroy($id)
    {
        return abort(404);
    }

    /**
     * @param  int  $id
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(int $id)
    {
        $previous = GalleriesController::getPreviousImage($id);
        $image    = GalleriesController::getImage($id);
        $next     = GalleriesController::getNextImage($id);


        return view('gallery.show', compact('previous', 'image', 'next'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function loadImages()
    {
        $request = request();
        if ($request->ajax()) {
            $visible_title = false;

            if ($request->id > 0) {
                $images = GalleriesController::ajaxLoadGalleryId($request->id);
            } else {
                $images = GalleriesController::ajaxLoadGallery();

                $visible_title = true;
            }

            return view('gallery.components.index', compact('images', 'visible_title'));
        }
    }

    /**
     * @param  int  $id
     *
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model
     */
    public static function getImage(int $id)
    {
        return UserGallery::with([
            'comments',
            'comments.user:id,avatar,name,country_id,race_id,rating,count_negative,count_positive',
            'comments.user.countries:id,name,flag',
            'comments.user.races:id,title',
            'comments.user' => function ($query) {
                $query->withCount('comments');
            },
        ])->findOrFail($id);
    }

    /**
     * @param  int  $id
     *
     * @return mixed
     */
    public static function getNextImage(int $id)
    {
        return UserGallery::with([
            'comments',
            'comments.user:id,avatar,name,country_id,race_id,rating,count_negative,count_positive',
            'comments.user.countries:id,name,flag',
            'comments.user.races:id,title',
            'comments.user' => function ($query) {
                $query->withCount('comments');
            },
        ])->where('id', '>', $id)->min('id');
    }

    /**
     * @param  int  $id
     *
     * @return mixed
     */
    public static function getPreviousImage(int $id)
    {
        return UserGallery::with([
            'comments',
            'comments.user:id,avatar,name,country_id,race_id,rating,count_negative,count_positive',
            'comments.user.countries:id,name,flag',
            'comments.user.races:id,title',
            'comments.user' => function ($query) {
                $query->withCount('comments');
            },
        ])->where('id', '<', $id)->max('id');
    }

    /**
     * @param  int  $user_gallery
     * @param  int  $user_id
     *
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model
     */
    public static function getUserImage(int $user_gallery, int $user_id)
    {
        return UserGallery::with([
            'comments',
            'comments.user:id,avatar,name,country_id,race_id,rating,count_negative,count_positive',
            'comments.user.countries:id,name,flag',
            'comments.user.races:id,title',
            'comments.user' => function ($query) {
                $query->withCount('comments');
            },
        ])->where('user_id', $user_id)->findOrFail($user_gallery);
    }


    /**
     * @param  int  $user_gallery
     * @param  int  $user_id
     *
     * @return mixed
     */
    public static function getNextUserImage(int $user_gallery, int $user_id)
    {
        return UserGallery::with([
            'comments',
            'comments.user:id,avatar,name,country_id,race_id,rating,count_negative,count_positive',
            'comments.user.countries:id,name,flag',
            'comments.user.races:id,title',
            'comments.user' => function ($query) {
                $query->withCount('comments');
            },
        ])->where('user_id', $user_id)->where('id', '>', $user_gallery)->min('id');
    }

    /**
     * @param  int  $user_gallery
     * @param  int  $user_id
     *
     * @return mixed
     */
    public static function getPreviousUserImage(int $user_gallery, int $user_id)
    {
        return UserGallery::with([
            'comments',
            'comments.user:id,avatar,name,country_id,race_id,rating,count_negative,count_positive',
            'comments.user.countries:id,name,flag',
            'comments.user.races:id,title',
            'comments.user' => function ($query) {
                $query->withCount('comments');
            },
        ])->where('user_id', $user_id)->where('id', '<', $user_gallery)->max('id');
    }

    /**
     * @param  int  $id
     *
     * @return mixed
     */
    public static function ajaxLoadGalleryId(int $id)
    {
        return UserGallery::where('id', '<', $id)
            ->orderByDesc('id')
            ->limit(8)
            ->get(['id', 'picture', 'user_id',]);
    }

    /**
     * @return mixed
     */
    public static function ajaxLoadGallery()
    {
        return UserGallery::orderByDesc('id')
            ->limit(8)
            ->get(['id', 'picture', 'user_id',]);
    }

    /**
     * @param  int  $user_id
     * @param  int  $id
     *
     * @return mixed
     */
    public static function ajaxLoadUserGalleryId(int $user_id, int $id)
    {
        return UserGallery::where('user_id', $user_id)
            ->where('id', '<', $id)
            ->orderByDesc('id')
            ->limit(8)
            ->get(['id', 'picture', 'user_id',]);
    }

    /**
     * @param  int  $user_id
     *
     * @return mixed
     */
    public static function ajaxLoadUserGallery(int $user_id)
    {
        return UserGallery::where('user_id', $user_id)
            ->orderByDesc('id')
            ->limit(8)
            ->get(['id', 'picture', 'user_id',]);
    }

    /**
     * @param  \App\Http\Requests\CommentsStoreRequests  $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function saveComments(CommentsStoreRequests $request)
    {
        $content = clean($request->input('content'));

        if (empty($content)) {
            return redirect()->back();
        }
        $model   = UserGallery::findOrFail($request->get('id'));
        $comment = new Comment([
            'user_id' => auth()->id(),
            'content' => $content,
        ]);

        $model->comments()->save($comment);

        return redirect()->back();
    }

}
