<?php
/**
 * Created by PhpStorm.
 * User: MAX
 * Date: 30.10.2019
 * Time: 17:27
 */

namespace App\Services\User;

use App\Models\UserFriend;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserService
{

    public static function isFriendExists($user_id, $friend_user_id)
    {
        if (UserFriend::where('user_id', $user_id)->where('friend_user_id', $friend_user_id)->exists()) {
            return true;
        }
        return false;
    }
}