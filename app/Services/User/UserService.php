<?php
/**
 * Created by PhpStorm.
 * User: MAX
 * Date: 30.10.2019
 * Time: 17:27
 */

namespace App\Services\User;

use App\Models\UserFriend;
use App\Services\ServiceAssistants\PathHelper;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserService
{
    /**
     * Update user data profile
     *
     * @param Request $request
     * @param $user_id
     * @return mixed
     */
    public static function updateData(Request $request, $user_id)
    {
        $user = User::find($user_id);
        $user_data = $request->all();

        foreach ($user_data as $key => $item) {
            if (is_null($item)) {
                unset($user_data[$key]);
            }
        }

        if (isset($user_data['country'])) { // country_id
            $user_data['country_id'] = $user_data['country'];
            unset($user_data['country']);
        }

        if (isset($user_data['userbar'])) {
            $user_data['userbar_id'] = $user_data['userbar'];
            unset($user_data['userbar']);
        }

        $user_data['avatar'] = self::saveFile($request, $user, $user_data);
        /*if ($request->file('avatar')) {
            $title = 'Аватар ' . $user->name;
            $file = File::storeFile($request->file('avatar'), 'avatars', $title);

            $user_data['file_id'] = $file->id;
        }*/

        if (isset($user_data['signature'])) {
            $signature = preg_replace('#<script(.*?)>(.*?)</script>#is', '', $user_data['signature']);
            $user_data['signature'] = preg_replace('/(<[^>]+) style=".*?"/i', '$1', $signature);
        }

        if (Auth::user()->roles ? (Auth::user()->roles->name != 'super-admin') : true) {
            unset($user_data['role_id']);
        }

        $user->update($user_data);
        return User::find($user_id);
    }

    public static function isFriendExists($user_id, $friend_user_id)
    {
        if (UserFriend::where('user_id', $user_id)->where('friend_user_id', $friend_user_id)->exists()) {
            return true;
        }
        return false;
    }


    public static function getUserId()
    {
        return request('id') === null ? auth()->id() : request('id');

    }

    public static function saveFile($request, $data, $user_data)
    {
        // Check have input file
        if ($request->hasFile('avatar')) {
            // Check if upload file Successful Uploads
            if ($request->file('avatar')->isValid()) {
                // Check path

                PathHelper::checkUploadStoragePath("/image/user/avatar");
                // Check old file
                PathHelper::checkAvatarAndDelete($data->avatar);

                // Upload file on server
                $image = $request->file('avatar');
                $filePath = $image->store('/image/user/avatar', 'public');
                return 'storage/' . $filePath;
            } else {
                back();
            }
        }
        return null;
    }
}
