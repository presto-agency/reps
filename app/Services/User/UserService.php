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
    public static function updateData($request, $user_id)
    {
        $user = User::findOrFail($user_id);
        if ($user->id != auth()->id()) {
            return redirect()->to('/');
        }

        $user_data = $request->all();
        if ($request->exists('view_avatars') == false) {
            $user_data['view_avatars'] = '0';
        }

        foreach ($user_data as $key => $item) {
            if (is_null($item)) {
                unset($user_data[$key]);
            }
        }

        if (isset($user_data['country'])) {
            $user_data['country_id'] = $user_data['country'];
            unset($user_data['country']);
        }
        if (isset($user_data['race'])) {
            $user_data['race_id'] = $user_data['race'];
            unset($user_data['race']);
        }

        $user_data['avatar'] = self::saveFile($request, $user, $user_data);

        if (is_null($user_data['avatar'])) {
            unset($user_data['avatar']);
        }

        $user->update($user_data);
        return true;
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
                // Check Old file delete if exists and path create if not exists
                PathHelper::checkUploadsFileAndPath("/images/users/avatars", auth()->user()->avatar);
                // Upload file on server
                $image = $request->file('avatar');
                $filePath = $image->store('/images/users/avatars', 'public');
                return 'storage/' . $filePath;
            } else {
                back();
            }
        }
        return null;
    }
}
