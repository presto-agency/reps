<?php

namespace App\Http\Controllers;

use App\Events\NewChatMessageAdded;
use App\Models\PublicChat;
use App\Services\GeneralViewHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    private $selected_user = '';

    public function __construct()
    {
        $this->general_helper = new GeneralViewHelper;
//        $this->chat_helper = new ChatViewHelper;
    }

    /**
     * Get 100 messages
     */
    public function get_messages()
    {
        $messages = PublicChat::select('id', 'user_id', 'user_name', 'message', 'to', 'file_path', 'imo', 'created_at')->with('user')
            ->orderBy('created_at', 'desc')
            ->limit(100)
            ->get();

//        return $messages;
//        return view('stream-section.test-chat', compact('messages'));

        $result = array();
        foreach ($messages as $msg) {
            $result[] = $this->setFullMessage($msg);
        }

        return $result;
    }

    /**
     * Insert new messages from chat
     */
    public function insert_message(Request $request)
    {

        $message_data = $request->all();

        if (Auth::id() == $request->user_id) {
            $message_data['user_name'] = Auth::user()->name;
//            $message_data['message'] = $this->chat_helper->rewrapperText($message_data['message']);
            $message_data['message'] = $request->message;
            $message_data['to'] = $this->selected_user;
            $insert = PublicChat::create($message_data);

//            \Log::info($insert);
            if ($insert) {
                $insert->load('user');

                $insert = $this->setFullMessage($insert);
                event(new NewChatMessageAdded($insert));

//                return redirect()->back();
                return response()->json([
                    'status' => 'ok',
                    'id' => $insert->id, 'user' => Auth::id()
                ], 200);
            }

        } else {
            return response()->json([
                'status' => 'fail'
            ], 200);
        }
    }


    public function setFullMessage($msg)
    {
        $countries = $this->general_helper->getCountries();
//        $country_code = ($msg->user->country_id) ? mb_strtolower($countries[$msg->user->country_id]->code) : '';
        $country_flag = ($msg->user->country_id) ? $countries[$msg->user->country_id]->flag : '';
//        $race = ($msg->user->race) ? Replay::$race_icons[$msg->user->race] : Replay::$race_icons['All'];
//        $len_check = strlen($msg->message) > 350 ? true : false;
//        $short_msg = $len_check ? $this->general_helper->closeAllTags(mb_substr($msg->message, 0, 350, 'utf-8')) . '... ' : $msg->message;
        /*$result = array(
            'user_id' => $msg->user_id,
            'user_name' => $msg->user_name,
            'message' => $msg->message,
//            'short_msg' => $short_msg,
//            'more_length' => $len_check,
//            'show_more' => true,
            'to' => $msg->to,
            'file_path' => $msg->file_path,
            'imo' => $msg->imo,
            'created_at' => $msg->created_at,
            'time' => $msg->created_at->format('h:mm'),
//            'country_code' => $country_code,
//            'race' => $race
        );*/

        $msg->time = $msg->created_at->format('H:i');
        $msg->country_flag = $country_flag;

        return $msg;
    }


}
