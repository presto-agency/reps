<?php

namespace App\Http\Controllers;

use App\Events\NewChatMessageAdded;
use App\Models\PublicChat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    private $selected_user = '';

    /**
     * Get 100 messages
     */
    public function get_messages()
    {
        $messages = PublicChat::select('user_id', 'user_name', 'message', 'to', 'file_path', 'imo', 'created_at')->with('user')
            ->orderBy('created_at', 'desc')
            ->limit(100)
            ->get();

        return view('stream-section.test-chat', compact('messages'));

        /*$result = array();
        foreach ($messages as $msg) {
            $result[] = $this->setFullMessage($msg);
        }

        return $result;*/
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

            if ($insert) {

                event(new NewChatMessageAdded($message_data));

                return redirect()->back();
                /*return response()->json([
                    'status' => 'ok',
                    'id' => $insert->id, 'user' => Auth::id()
                ], 200);*/
            }

        } else {
            return response()->json([
                'status' => 'fail'
            ], 200);
        }
    }
}
