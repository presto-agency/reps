<?php
/**
 * Created by PhpStorm.
 * User: MAX
 * Date: 17.11.2019
 * Time: 21:36
 */

namespace App\Services\User;


use App\Models\Dialogue;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class MessageService
{

    /**
     * Get data for message view
     *
     * @param $id
     *
     * @return array
     */
    public static function getMessageData($id)
    {
        $contacts = UserDialogService::getUserDialogues();
        $data     = self::formMessageData($id, $contacts);

        return $data;

    }

    /**
     * @param $id
     * @param $contacts
     *
     * @return array
     */
    protected static function formMessageData($id, $contacts)
    {
        if (count($contacts)) {
            if ( ! $id) {

                foreach ($contacts->first()->senders as $sender) {
                    if ($sender->id != Auth::id()) {
                        $id = $sender->id;
                    }
                }

            }

            $dialogue  = UserDialogService::getDialogUser($id);
            $dialog_id = false;
            $messages  = '';
            if ($dialogue) {
                $dialog_id = $dialogue->id;
                $messages  = Dialogue::getUserDialogueContent($dialog_id);
            }

            return [
                'dialogue_id' => $dialog_id,
                'messages'    => $messages,
                'contacts'    => $contacts,
                'user'        => User::find($id),
                'page'        => Request::has('page') ? Request::input('page') + 1 : 2,
            ];
        } else {

            return [
                'dialogue_id' => false,
                'messages'    => '',
                'contacts'    => $contacts,
                'user'        => ! isset($id) ? false : User::find($id),
            ];
        }
    }

    /**
     * @param $dialog_id
     * @return mixed
     */
    public static function getContactUser($dialog_id)
    {
        return Dialogue::find($dialog_id)->users()->where('id','<>', Auth::id())->first();
    }
}