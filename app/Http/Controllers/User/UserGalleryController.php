<?php

namespace App\Http\Controllers\User;

use App\Http\Requests\UserGalleryRequests;
use App\Models\UserGallery;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserGalleryController extends Controller
{

    public static $routCheck;

    public function __construct()
    {
        self::$routCheck = GalleryHelper::checkUrlUsers();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $row = ['id', 'picture'];
        $images = GalleryHelper::getAllUserImages($row);
        $routCheck = self::$routCheck;
        return view('user.gallery.index', compact('images', 'routCheck'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('user.gallery.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param UserGalleryRequests $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(UserGalleryRequests $request)
    {
        $userGallery = new UserGallery;
        $userGallery->user_id =
        $userGallery->sign = $request->get('sign');
        if ($request->has('for_adults')) {
            $userGallery->for_adults = $request->get('for_adults');
        } else {
            $userGallery->for_adults = 0;
        }
        // Check have upload file
        if ($request->hasFile('picture')) {
            // Check if upload file Successful Uploads
            if ($request->file('picture')->isValid()) {
                // Upload file on server
                $image = $request->file('picture');
                $filePath = $image->store('image/user/gallery', 'public');
                $userGallery->picture = 'storage/' . $filePath;
            } else {
                back();
            }
        } else {
            back();
        }
        $userGallery->save();

        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $relation = ['comments'];
        $row = ['id', 'sign', 'positive_count', 'negative_count', 'picture',];
        $userImage = GalleryHelper::getUserImage($id, $relation, $row);

        // get previous user id
        $previous = GalleryHelper::previousUserImage($id, $relation, $row);

        // get next user id
        $next = GalleryHelper::nextUserImage($id, $relation, $row);

        $routCheck = self::$routCheck;
        return view('user.gallery.show', compact('userImage', 'previous', 'next', 'routCheck'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $relation = [];
        $row = ['id', 'sign', 'positive_count', 'negative_count', 'picture', 'sign', 'for_adults'];
        $userImage = GalleryHelper::getUserImage($id, $relation, $row);

        // get previous user id
        $previous = GalleryHelper::previousUserImage($id, $relation, $row);

        // get next user id
        $next = GalleryHelper::nextUserImage($id, $relation, $row);

        return view('user.gallery.edit', compact('userImage', 'previous', 'next'));
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
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return back();
    }

}
