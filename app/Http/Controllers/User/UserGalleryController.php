<?php

namespace App\Http\Controllers\User;

use App\Http\Requests\UserGalleryRequests;
use App\Models\UserGallery;
use App\Services\ServiceAssistants\PathHelper;
use App\Services\User\UserService;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserGalleryController extends Controller
{

    private $routCheck;

    public function __construct()
    {
        $this->routCheck = GalleryHelper::checkUrlGalleries();
    }


    /**
     * Display a listing of the resource.
     *
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index($id)
    {
        return view('user.gallery.index');
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
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(UserGalleryRequests $request, $id)
    {

        $userGallery = new UserGallery;
        $userGallery->user_id = auth()->id();
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
                // Check path
                PathHelper::checkUploadStoragePath("/images/users/galleries");
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
     * @param $id
     * @param $user_gallery
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($id, $user_gallery)
    {
        User::findOrFail($id);
        $relation = ['comments'];
        $row = ['id', 'sign', 'positive_count', 'negative_count', 'picture', 'user_id'];

        $userImage = GalleryHelper::getUserImage($user_gallery, $relation, $row);
        // get previous user id
        $previous = GalleryHelper::previousUserImage($user_gallery, $relation, $row);

        // get next user id
        $next = GalleryHelper::nextUserImage($user_gallery, $relation, $row);

        $routCheck = $this->routCheck;
        $user_id = UserService::getUserId();

        return view('user.gallery.show', compact('userImage', 'previous', 'next', 'routCheck', 'user_id'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @param int $user_gallery
     * @return \Illuminate\Http\Response
     */
    public function edit($id, $user_gallery)
    {
        User::findOrFail($id);
        $relation = [];
        $row = ['id', 'sign', 'positive_count', 'negative_count', 'picture', 'sign', 'for_adults'];
        $userImage = GalleryHelper::getUserImage($user_gallery, $relation, $row);

        // get previous user id
        $previous = GalleryHelper::previousUserImage($user_gallery, $relation, $row);

        // get next user id
        $next = GalleryHelper::nextUserImage($user_gallery, $relation, $row);
        $user_id = UserService::getUserId();
        return view('user.gallery.edit', compact('userImage', 'previous', 'next', 'user_id'));
    }

    /**
     * Update the specified resource in storage.
     *
     */
    public function update(Request $request, $id)
    {
        return redirect()->to('/');
    }

    /**
     * Remove the specified resource from storage.
     *
     */
    public function destroy($id)
    {
        return redirect()->to('/');
    }

    public function loadGallery()
    {
        User::findOrFail(request('id'));
        $row = ['id', 'picture', 'user_id'];

        if (request()->ajax()) {
            $visible_title = false;
            $routCheck = $this->routCheck;
            if (request('find_id') > 0) {
                $images = GalleryHelper::getAllUserImagesAjaxId($row, request('id'), request('find_id'));
            } else {
                $images = GalleryHelper::getAllUserImagesAjax($row, request('id'));

                $visible_title = true;
            }
            echo view('user.gallery.components.index',
                compact('images', 'routCheck', 'visible_title')
            );
        }
    }
}
