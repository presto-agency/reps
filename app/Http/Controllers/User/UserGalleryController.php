<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserGalleryRequests;
use App\Http\Requests\UserGalleryUpdateRequests;
use App\Models\UserGallery;
use App\Services\ServiceAssistants\PathHelper;
use App\Services\User\UserService;
use App\User;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\View\View;

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
     *
     * @return Factory|View
     */
    public function index($id)
    {
        return view('user.gallery.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('user.gallery.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param UserGalleryRequests $request
     * @param                       $id
     *
     * @return RedirectResponse
     */
    public function store(UserGalleryRequests $request, $id)
    {

        $userGallery = new UserGallery;
        $userGallery->user_id = auth()->id();
        $userGallery->sign = clean($request->get('sign'));
        if ($request->has('for_adults')) {
            $userGallery->for_adults = 1;
        } else {
            $userGallery->for_adults = 0;
        }

        // Check have upload file
        if ($request->hasFile('picture')) {
            // Check if upload file Successful Uploads
            if ($request->file('picture')->isValid()) {
                // Check path
                PathHelper::checkUploadsFileAndPath("/images/users/galleries");
                // Upload file on server
                $image = $request->file('picture');
                $filePath = $image->store(
                    'images/users/galleries',
                    'public'
                );
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
     *
     * @return Factory|View
     */
    public function show($id, $user_gallery)
    {

        User::findOrFail($id);
        $relation = ['comments'];
        $row = [
            'id',
            'sign',
            'positive_count',
            'negative_count',
            'picture',
            'user_id',
        ];

        $userImage = GalleryHelper::getUserImage($user_gallery, $relation);
        // get previous user id
        $previous = GalleryHelper::previousUserImage($id, $user_gallery);

        // get next user id
        $next = GalleryHelper::nextUserImage($id, $user_gallery);

        $routCheck = $this->routCheck;
        $user_id = UserService::getUserId();

        return view(
            'user.gallery.show',
            compact('userImage', 'previous', 'next', 'routCheck', 'user_id')
        );

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @param int $user_gallery
     *
     * @return Response
     */
    public function edit($id, $user_gallery)
    {
        User::findOrFail($id);
        $relation = [];
        $row = [
            'id',
            'sign',
            'positive_count',
            'negative_count',
            'picture',
            'sign',
            'for_adults',
        ];
        $userImage = GalleryHelper::getUserImage($user_gallery, $relation);

        // get previous user id

        $previous = GalleryHelper::previousUserImage($user_gallery, $id);

        // get next user id
        $next = GalleryHelper::nextUserImage($user_gallery, $id);
        $user_id = UserService::getUserId();

        return view(
            'user.gallery.edit',
            compact('userImage', 'previous', 'next', 'user_id')
        );
    }

    /**
     *
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\UserGalleryUpdateRequests $request
     * @param                                                $id
     * @param                                                $user_gallery
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UserGalleryUpdateRequests $request, $id, $user_gallery)
    {
        User::findOrFail($id);
        $getData = UserGallery::findOrFail((int)$user_gallery);
        if ($getData->user_id !== auth()->id()) {
            return back();
        }
        $getData->user_id = auth()->id();
        $getData->sign = clean($request->sign);
        if ($request->has('for_adults')) {
            $getData->for_adults = 1;
        } else {
            $getData->for_adults = 0;
        }

        $getData->save();

        return back();
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
        $row = [
            'id',
            'picture',
            'user_id',
        ];

        if (request()->ajax()) {
            $visible_title = false;
            $routCheck = $this->routCheck;
            if (request('find_id') > 0) {
                $images = GalleryHelper::getAllUserImagesAjaxId(
                    $row,
                    request('id'), request('find_id')
                );
            } else {
                $images = GalleryHelper::getAllUserImagesAjax(
                    $row,
                    request('id')
                );

                $visible_title = true;
            }
            echo view(
                'user.gallery.components.index',
                compact('images', 'routCheck', 'visible_title')
            );
        }
    }

}
