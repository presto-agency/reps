<?php
/**
 * Created by PhpStorm.
 * User: MAX
 * Date: 17.11.2019
 * Time: 21:30
 */

namespace App\Services\User;


use App\Models\Dialogue;
use Auth;

class UserDialogService
{

    /**
     * Get User Dialogs
     *
     * @return mixed
     */
    public static function getUserDialogues()
    {

        $dialogues = Dialogue::whereHas('users', function ($query) {
            $query->where('user_id', Auth::id());
        })->with('messages.sender')->get();

        /*$dialogues = Dialogue::whereHas('users', function ($query){
            $query->where('user_id', Auth::id());
        })->with('messages.sender', 'users.avatar')
            ->withCount(['messages as new_messages' => function($query){
                $query->where('user_id', '<>', Auth::id())
                    ->where('is_read',0);
            }])
            ->paginate(10);*/

        $dialogues->transform(function ($item) {
            $item->senders       = $item->users->unique();
            $item->messages_last = $item->messages->max('created_at');
            unset($item->users);
            unset($item->messages);

            return $item;
        });

        return $dialogues;
    }

    /**
     * get dialogue by user
     *
     * @param $user_id
     *
     * @return mixed
     */
    public static function getDialogUser($user_id)
    {
        $dialogue = Dialogue::where(function ($q) use ($user_id) {
            $q->whereHas('users', function ($query) use ($user_id) {
                $query->where('users.id', $user_id);
            })->whereHas('users', function ($query) {
                $query->where('users.id', Auth::id());
            });
        })->with('users')->first();

        /*if(!$dialogue){
            $dialogue = new Dialogue();
            $dialogue->save();

            $dialogue->users()->attach([$user_id, Auth::id()]);
        }*/

        return $dialogue;
    }

}