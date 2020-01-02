<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateProfileRequest;
use App\Models\UserFriend;
use App\Services\ImageService\ResizeImage;
use App\Services\ServiceAssistants\PathHelper;
use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{


    public function index()
    {
        return abort(404);
    }


    public function create()
    {
        return abort(404);
    }


    public function store(Request $request)
    {
        return abort(404);
    }

    public function destroy($id)
    {
        return abort(404);
    }

    public function show($id)
    {
        $user     = User::getUserDataById($id);
        $friends  = UserFriend::getFriends($user);
        $friendly = UserFriend::getFriendlies($user);

        return view('user.profile-show')->with([
            'friends'  => $friends,
            'friendly' => $friendly,
            'user'     => $user,
        ]);
    }

    /**
     * @param  int  $id
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(int $id)
    {
        $user = User::findOrFail(auth()->id());

        return view('user.profile-edit', compact('user'));
    }


    public function update(UpdateProfileRequest $request, int $id)
    {
        $user = User::findOrFail(auth()->id());

        $user->name         = (string) $request->get('name');
        $user->email        = (string) $request->get('email');
        $user->country_id   = (integer) $request->get('country');
        $user->race_id      = (integer) $request->get('race');
        $user->birthday     = $request->get('birthday');
        $user->homepage     = (string) $request->get('homepage');
        $user->isq          = (string) $request->get('isq');
        $user->skype        = (string) $request->get('skype');
        $user->vk_link      = (string) $request->get('vk_link');
        $user->fb_link      = (string) $request->get('fb_link');
        $user->view_avatars = (boolean) $request->get('view_avatars');
        /**
         * Save Avatar
         */
        if ($request->hasFile('avatar') && $request->file('avatar')->isValid()) {
            $file = $request->file('avatar');
            /**
             * Check path and delete old file
             */
            $path = PathHelper::checkUploadsFileAndPath('images/users/avatars', auth()->user()->avatar);
            /**
             * Check file for resize
             */
            if ($file->getClientOriginalExtension() == "gif") {
                $filePath = 'storage/'.$file->store('images/users/avatars', 'public');
            } else {
                $filePath = ResizeImage::resizeImg($file, 125, 125, true, $path);
            }
            $user->avatar = $filePath;
        }

        $user->save();

        return redirect()->route('edit_profile', ['id' => auth()->id()]);
    }

}
