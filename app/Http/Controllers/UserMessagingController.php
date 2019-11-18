<?php

namespace App\Http\Controllers;

use App\Events\NewUserMessageAdded;
use App\Http\Requests\SendUserMessageRequest;
use App\Models\Dialogue;
use App\Models\UserMessage;
use App\Services\User\MessageService;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserMessagingController extends Controller
{
    /**
     * Get message list for user
     *
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getUser($id = false)
    {
        if($id && $id == Auth::id()){
            return redirect()->route('user.messages_all');
        } else {

//            if ($id){
//                dd('user id='.$id);

//                return view('user.messages')->with(MessageService::getMessageData($id));

            //знаходимо користувача
            /*$user = '';
            if(!$id){
                $id = Auth::id();
                $user = Auth::user();
            }else{
                $user = User::find($id);
            }*/



                return view('user.messages')->with(MessageService::getMessageData($id));
               /* }else{
                    $dialogue = '';
                    $messages = '';
                    return view('user.messages', compact('user', 'dialogues', 'dialogue', 'messages'));
                }*/
            /*}else{
//                dd('auth id='.$id);
                $id = Auth::id();
                $user = Auth::user();
                return view('user.messages', compact('user'));

//                return view('user.messages')->with(MessageService::getMessageData($id));
            }*/

        }

    }

    /**
     * Get User Dialogs
     *
     * @return mixed
     */
    public function getUserDialogues()
    {

//        $dialogues = Dialogue::all();

        $dialogues = Dialogue::whereHas('users', function ($query){
            $query->where('user_id', Auth::id());
        })->with('messages.sender')->get();


        /*$dialogues = Dialogue::whereHas('users', function ($query){
            $query->where('user_id', Auth::id());
        })*//*->with('messages.sender')*/
            /*->withCount(['messages as new_messages' => function($query){
                $query->where('user_id', '<>', Auth::id())
                    ->where('is_read',0);
            }])*/
            /*->get(10);*/

        $dialogues->transform(function ($item)
        {
            $item->senders = $item->users->unique();
            $item->messages_last = $item->messages->max('created_at');
            unset($item->users);
            unset($item->messages);
            return $item;
        });

        return $dialogues;
    }


    public function send(Request $request){
//        SendUserMessageRequest
        $dialogue_id = (integer)$request->dialogue_id;
        if ($dialogue_id){

            $message = UserMessage::createMessage($request, $dialogue_id);
            if ($message) {

                event(new NewUserMessageAdded($message));

                return response()->json($message);
            }
        }else{
            $user_id = $request->to_id;
            if ($user_id){
                $dialogue = new Dialogue();
                $dialogue->save();

                $dialogue->users()->attach([$user_id, Auth::id()]);

                $message = UserMessage::createMessage($request, $dialogue->id);

                if ($message) {

                    event(new NewUserMessageAdded($message));

                    return response()->json($message);
                }

            }

        }
//        dd($request->all());
//        return back();

    }
}
