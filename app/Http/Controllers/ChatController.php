<?php

namespace App\Http\Controllers;

use App\Events\NewChatMessageAdded;
use App\Models\ChatPicture;
use App\Models\ChatSmile;
use App\Models\Help;
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
        $messages = PublicChat::select('id', 'user_id', 'user_name', 'message', 'is_hidden', 'to', 'file_path', 'imo', 'created_at')->with('user')
            ->orderBy('created_at', 'desc')
            ->limit(100)
            ->get();

        //        return $messages;
        //        return view('stream-section.test-chat', compact('messages'));

        $result = [];
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

            $message = clean($request->message);
            if (empty($message)) {
                return response()->json([
                    'status' => 'fail',
                ], 200);
            }
            $message_data['message'] = $message;
            $message_data['to']      = $this->selected_user;
            $insert                  = PublicChat::create($message_data);

            if ($insert) {
                $insert->load('user');
                $resultModel = $this->setFullMessage($insert);
                event(new NewChatMessageAdded($resultModel));

                return response()->json([
                    'status' => 'ok',
                    'data'   => $resultModel, 'user' => Auth::id(),
                ], 200);
            }
        } else {
            return response()->json([
                'status' => 'fail',
            ], 200);
        }
    }


    public function setFullMessage($msg)
    {
        $countries = $this->general_helper->getCountries();
        //        $country_code = ($msg->user->country_id) ? mb_strtolower($countries[$msg->user->country_id]->code) : '';
        $country_flag = isset($msg->user->country_id) ? $countries[$msg->user->country_id]->flag : '';

        //        $country_flag = ($msg->user->countries) ? $msg->user->countries->flag : '';
        //        $race = ($msg->user->race) ? Replay::$race_icons[$msg->user->race] : Replay::$race_icons['All'];
        //        $len_check = strlen($msg->message) > 350 ? true : false;
        //        $short_msg = $len_check ? $this->general_helper->closeAllTags(mb_substr($msg->message, 0, 350, 'utf-8')) . '... ' : $msg->message;
        return [
            'id'           => $msg->id,
            'user_id'      => $msg->user_id,
            'user_name'    => $msg->user_name,
            'message'      => clean($msg->message),
            'to'           => $msg->to,
            'file_path'    => $msg->file_path,
            'imo'          => $msg->imo,
            'created_at'   => $msg->created_at,
            'time'         => $msg->created_at->format('H:i'),
            'country_flag' => $country_flag,
            'is_hidden'    => $msg->is_hidden,
            'user'         => $msg->user,
        ];
    }

    public function destroy($id)
    {
        $result = PublicChat::where('id', $id)->delete();
        if ($result) {
            $data = [
                'status' => '1',
                'msg'    => 'success',
            ];
        } else {
            $data = [
                'status' => '0',
                'msg'    => 'fail',
            ];
        }

        return response()->json($data);
    }

    /**
     * Get Chat Smiles
     */
    public function get_externalsmiles()
    {
        $smiles      = [];
        $extraSmiles = ChatSmile::orderBy('updated_at', 'Desc')->get();
        foreach ($extraSmiles as $smile) {
            $smiles[] = [
                'charactor' => $smile->charactor,
                'filename'  => pathinfo($smile->image)["basename"],
            ];
        }

        return response()->json([
            'status' => "ok",
            'smiles' => $smiles,
        ], 200);
    }

    /**
     * Get Chat Images
     */
    public function get_externalimages()
    {
        $images      = [];
        $extraImages = ChatPicture::with('tags')->orderBy('updated_at', 'Desc')->get();

        foreach ($extraImages as $image) {
            foreach ($image->tags as $tag) {
                if ( ! isset($images[$tag->name])) {
                    $images[$tag->name] = [];
                }
                array_push($images[$tag->name], [
                    'charactor' => $image->charactor,
                    'filepath'  => $image->image,
                ]);
            }
        }

        return response()->json([
            'status' => "ok",
            'images' => $images,
        ], 200);
    }

    public function get_helps(){
        $helps = Help::where('key','helps_for_chat')->first();
        if ($helps){
            return response()->json([
                'status' => true,
                'message' => 'ok',
                'helps' => $helps->value,
            ], 200);
        }else{
            return response()->json([
                'status' => false,
                'message' => 'Not Found'
            ], 404);
        }
    }

}
