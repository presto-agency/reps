<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Gallery\GalleriesController;
use App\Http\Requests\UserGalleryRequests;
use App\Http\Requests\UserGalleryUpdateRequests;
use App\Models\UserGallery;
use App\User;

class UserGalleryController extends Controller
{

    /**
     * @param  int  $id
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(int $id)
    {
        User::findOrFail($id);

        return view('user.gallery.index');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('user.gallery.create');
    }

    public function destroy($id)
    {
        return abort(404);
    }


    /**
     * @param  int  $id
     * @param  int  $user_gallery
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(int $id, int $user_gallery)
    {
        User::findOrFail($id);

        $previous = GalleriesController::getPreviousUserImage($user_gallery, $id);
        $image    = GalleriesController::getUserImage($user_gallery, $id);
        $next     = GalleriesController::getNextUserImage($user_gallery, $id);


        return view('user.gallery.show', compact('previous', 'image', 'next'));
    }

    /**
     * @param $id
     * @param $user_gallery
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id, $user_gallery)
    {
        User::findOrFail($id);

        $previous  = GalleriesController::getPreviousUserImage($user_gallery, $id);
        $userImage = GalleriesController::getUserImage($user_gallery, $id);
        $next      = GalleriesController::getNextUserImage($user_gallery, $id);

        return view('user.gallery.edit', compact('previous', 'userImage', 'next'));
    }

    /**
     * @param  \App\Http\Requests\UserGalleryRequests  $request
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(UserGalleryRequests $request, int $id)
    {
        $userImage             = new UserGallery;
        $userImage->sign       = clean($request->get('sign'));
        $userImage->for_adults = (boolean) $request->get('for_adults');

        /**
         * Check file on server
         */
        if ( ! $request->hasFile('picture') || ! $request->file('picture')->isValid()) {
            return redirect()->back();
        }
        /**
         * Upload file on server
         */
        $filePath           = $request->file('picture')->store('images/users/galleries', 'public');
        $userImage->picture = 'storage/'.$filePath;
        $userImage->save();

        return redirect()->back();
    }

    /**
     * @param  \App\Http\Requests\UserGalleryUpdateRequests  $request
     * @param  int  $id
     * @param  int  $user_gallery
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UserGalleryUpdateRequests $request, int $id, int $user_gallery)
    {
        User::findOrFail($id);

        $userImage             = UserGallery::find($user_gallery);
        $userImage->sign       = clean($request->get('sign'));
        $userImage->for_adults = (boolean) $request->get('for_adults');
        $userImage->save();

        return redirect()->back();
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function loadUserImages()
    {
        $request = request();
        if ($request->ajax()) {
            $visible_title = false;

            if ($request->id > 0) {
                $userImages = GalleriesController::ajaxLoadUserGalleryId($request->user_id, $request->id);
            } else {
                $userImages = GalleriesController::ajaxLoadUserGallery($request->user_id);

                $visible_title = true;
            }

            return view('user.gallery.components.index', compact('userImages', 'visible_title'));
        }
    }

}
