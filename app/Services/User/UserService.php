<?php
/**
 * Created by PhpStorm.
 * User: MAX
 * Date: 30.10.2019
 * Time: 17:27
 */

namespace App\Services\User;

use App\Models\UserFriend;
use App\Services\ImageService\ResizeImage;
use App\Services\ServiceAssistants\PathHelper;
use App\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Log;

class UserService
{

    /**
     * Update user data profile
     *
     * @param  Request  $request
     * @param $user_id
     *
     * @return mixed
     */
    public static function updateData($request, $user_id)
    {
        $user = User::query()->findOrFail($user_id);
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

        $user_data['avatar'] = self::saveFile($request);

        if (is_null($user_data['avatar'])) {
            unset($user_data['avatar']);
        }

        $user->update($user_data);

        return true;
    }

    public static function isFriendExists($user_id, $friend_user_id)
    {
        if (UserFriend::query()->where('user_id', $user_id)
            ->where('friend_user_id', $friend_user_id)->exists()
        ) {
            return true;
        }

        return false;
    }

    /**
     *  Save Avatar
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return string|null
     */
    public static function saveAvatar(Request $request)
    {
        $filePath = null;

        if ($request->hasFile('avatar') && $request->file('avatar')->isValid()) {
            try {
                $file = $request->file('avatar');
                /**
                 * Check path and delete old file
                 */
                $now   = Carbon::now();
                $pathC = $now->format('F').$now->year;
                $path  = PathHelper::checkUploadsFileAndPath("images/users/avatars/{$pathC}", auth()->user()->avatar);
                /**
                 * Check file for resize
                 */
                if ($file->getClientOriginalExtension() == "gif") {
                    $filePath = 'storage/'.$file->store("images/users/avatars/{$pathC}", 'public');
                } else {
                    $filePath = ResizeImage::resizeImg($file, 125, 125, true, "$path/");
                }
            } catch (Exception $e) {
                Log::error($e->getMessage());
            }
        }

        return $filePath;
    }

}
