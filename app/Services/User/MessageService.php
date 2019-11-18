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

class MessageService
{
    /**
     * Get data for message view
     *
     * @param $id
     * @return array
     */
    public static function getMessageData($id)
    {
        $contacts = UserDialogService::getUserDialogues();
        $data =    self::formMessageData($id, $contacts);
        return $data;

    }
    /**
     * @param $id
     * @param $contacts
     * @return array
     */
    protected static function formMessageData($id, $contacts)
    {
        if (count($contacts)) {
            if(!$id){

                foreach ($contacts->first()->senders as $sender){
                    if ($sender->id != Auth::id()){
                        $id = $sender->id;
                    }
                }

            }

            $dialog_id = UserDialogService::getDialogUser($id)->id;

            return [
                'dialogue_id' => $dialog_id,
                'messages' => Dialogue::getUserDialogueContent($dialog_id),
                'contacts' => $contacts,
                'user' => User::find($id),
            ];
        } else {

            return  [
                'dialogue_id' => false,
                'messages' => '',
                'contacts' => $contacts,
                'user' => !isset($id) ? false : User::find($id),
            ];
        }
    }
}