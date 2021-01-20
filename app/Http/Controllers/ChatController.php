<?php

namespace App\Http\Controllers;

use App\Broadcasting\CheckChatMessage;
use App\Events\BanUserChat;
use App\Events\ChangeNameUser;
use App\Events\CheckNewMessage;
use App\Events\NewChatMessageAdded;
use App\Events\UnBanUserChat;
use App\Models\Bet;
use App\Models\ChatPicture;
use App\Models\ChatSmile;
use App\Models\Deal;
use App\Models\GasTransaction;
use App\Models\Help;
use App\Models\PublicChat;
use App\Services\GeneralViewHelper;
use App\User;
use Broadcast;
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
        $messages = PublicChat::/*select('id', 'user_id', 'user_name', 'message', 'is_hidden', 'to', 'file_path', 'imo', 'created_at')->*/with('user')
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


    protected function command(string $message){
        $patterns = [
            "/^\/cn\b/i",
            "/^\/ccnn\b/i",
            "/^\/b\b/i",
            "/^\/ab\b/i",
            "/^\/tr\b/i",
            "/^\/anon\b/i",
            "/^\/sb\b/i",
            "/^\/deal\b/i",
            "/^\/win\b/i",
            "/^\/bet\b/i",
        ];
        foreach ($patterns as $pattern){
            if(preg_match($pattern, $message,$matches))
                return $matches[0];

//            preg_replace($pattern,'',$message);
        }

    }

    /**
     * Insert new messages from chat
     */
    public function insert_message(Request $request)
    {
        $message_data = $request->all();

        if ((Auth::id() == $request->user_id) && (auth()->user()->ban_chat == 0)) {


//        $pattern = "/^\/cn\b/i";

        $command = $this->command($request->message);

//        dump($command, $request->message);
        switch ($command){
            case '/cn':

                $pattern = "/(?P<comand>^\/cn\b) (?P<newname>\w+)/i";
//                preg_match('/(foo)(bar)(baz)/', 'foobarbaz', $matches, PREG_OFFSET_CAPTURE);

                // перевірка на аргументи
                if(preg_match($pattern, $request->message,$matches)){
                    $user = auth()->user();
                    $balance = $user->gas_balance;
                    $newName = $matches['newname'];

                    // перевіряємо чи достатньо газів на балансі
                    if ($balance >= 20){

                        $data = [
                            'user_id' => auth()->user()->id,
                            'outgoing' => 20,
                            'description' => "Изминение имени на $newName"
                        ];

                        // створюємо транзакцію для списання газів
                        $transaction = new GasTransaction($data);
                        $user->gas_transactions()->save($transaction);

                        // змінюємо імя юзера
                        $user->name = $newName;
                        $user->save();

                        // створити подію для відправки по сокету зміненого імені
                        $changeUser = [
                            'id' => $user->id,
                            'name' => $user->name
                        ];
                        event(new ChangeNameUser($changeUser));

                        // записати меседж в базу про зміну імені
                        $message_data['message'] = "Пользователь #$user->id изменил имя на $user->name";
                        $message = $this->saveMessage($message_data);
                        if ($message){
//                             echo 'message збережено';
                            return response()->json([
                                'status' => 'ok',
                                'is_command' => true,
                                'data'   => [
                                    'model' => $message,
                                ],
                            ], 200);
                        }else{
                            // echo 'message помилка збереження';
                            return response()->json([
                                'status' => false,
                                'message' => 'No save message'
                            ], 500);
                        }

                        // відправити респонс про успішне виконання команди

                    }else{
                        return response()->json([
                            'status' => false,
                            'message' => 'No gas balance'
                        ], 404);
                    }
                }else{
                    return response()->json([
                        'status' => false,
                        'message' => 'Error command argument'
                    ], 404);
                }


                break;

            case '/ccnn':

                $pattern = "/(?P<comand>^\/ccnn\b) (?P<userid>\d+) (?P<newname>\w+)/i";

                if(preg_match($pattern, $request->message,$matches)){

                    $user_id = $matches['userid'];
                    $newName = $matches['newname'];

                    $user = User::find($user_id);

                    if ($user){

                        $initUser = auth()->user();
                        $number = 100; //количество сообщений
                        $amount = 20 * $number;
                        $balance = $initUser->gas_balance;
                        // перевіряємо чи достатньо газів на балансі
                        if ($balance >= $amount){

                            $data = [
                                'user_id' => auth()->user()->id,
                                'outgoing' => 20,
                                'description' => "Изминение имени на $newName у пользователя #$user->id"
                            ];

                            // створюємо транзакцію для списання газів
                            $transaction = new GasTransaction($data);
                            $user->gas_transactions()->save($transaction);


                            // зберігаємо оригінальне імя і записуємо кількість повідомлень


                            // змінюємо імя юзера
                            $user->name = $newName;
                            $user->save();

                            // створити подію для відправки по сокету зміненого імені
                            $changeUser = [
                                'id' => $user->id,
                                'name' => $user->name
                            ];
                            event(new ChangeNameUser($changeUser));

                            // записати меседж в базу про зміну імені
                            $message_data['message'] = "Пользователь #$initUser->id($initUser->name) изменил имя на $user->name у пользователя #$user->id";
                            $message = $this->saveMessage($message_data);
                            if ($message){
//                             echo 'message збережено';
                                return response()->json([
                                    'status' => 'ok',
                                    'is_command' => true,
                                    'data'   => [
                                        'model' => $message,
                                    ],
                                ], 200);
                            }else{
                                // echo 'message помилка збереження';
                                return response()->json([
                                    'status' => false,
                                    'message' => 'No save message'
                                ], 500);
                            }

                            // відправити респонс про успішне виконання команди

                        }else{
                            return response()->json([
                                'status' => false,
                                'message' => 'No gas balance'
                            ], 404);
                        }
                    }
                    return response()->json([
                        'status' => false,
                        'message' => 'Not found user'
                    ], 404);
                }else{
                    return response()->json([
                        'status' => false,
                        'message' => 'Error command argument'
                    ], 404);
                }

                break;

            case '/b':
                $pattern = "/(?P<comand>^\/b\b) (?P<userid>\d+) (?P<number>\d+)/i";
                if(preg_match($pattern, $request->message,$matches)){

                    $user_id = $matches['userid'];
                    $number = $matches['number'];
                    $amount = 5 * $number;

                    $user = User::find($user_id);
                    $initUser = auth()->user();
                    if ($user){

                        if ($user->id == $initUser->id){
                            return response()->json([
                                'status' => false,
                                'message' => 'Ban to yourself'
                            ], 403);
                        }

                        $balance = $initUser->gas_balance;
                        // перевіряємо чи достатньо газів на балансі
                        if ($balance >= $amount){

                            $data = [
                                'user_id' => $initUser->id,
                                'outgoing' => $amount,
                                'description' => "Бан пользователя #$user->id($user->name)"
                            ];

                            // створюємо транзакцію для списання газів
                            $transaction = new GasTransaction($data);
                            $initUser->gas_transactions()->save($transaction);

                            // записуємо кількість повідомлень для бана в БД до вже існуючої кількості
                            $user->ban_chat += abs($number) + 1;
                            $user->save();
                            // визвати подію, яка верне забаненого юзера( id, name, number)
                            $dataEvent = [
                                'user_id' => $user->id,
                                'name' => $user->name,
                                'number' => $user->ban_chat
                            ];
                            event(new BanUserChat($dataEvent));

                            // записати меседж в базу про зміну імені
                            $message_data['message'] = "Пользователь #$initUser->id($initUser->name) забанил на $number сообщений пользователя #$user->id($user->name)";
                            $message = $this->saveMessage($message_data);
                            if ($message){
                                // відправити респонс про успішне виконання команди
                                // echo 'message збережено';
                                return response()->json([
                                    'status' => true,
                                    'message' => 'Success',
                                    'is_command' => true,
                                    'data'   => [
                                        'model' => $message,
                                    ],
                                ], 200);
                            }else{
                                // echo 'message помилка збереження';
                                return response()->json([
                                    'status' => false,
                                    'message' => 'No save message'
                                ], 500);
                            }
                        }else{
                            return response()->json([
                                'status' => false,
                                'message' => 'No gas balance'
                            ], 404);
                        }
                    }
                    return response()->json([
                        'status' => false,
                        'message' => 'Not found user'
                    ], 404);
                }else{
                    return response()->json([
                        'status' => false,
                        'message' => 'Error command argument'
                    ], 404);
                }
                break;

            case '/ab':
                $pattern = "/(?P<comand>^\/ab\b) (?P<userid>\d+)/i";
                if(preg_match($pattern, $request->message,$matches)){

                    $user_id = $matches['userid'];

                    $user = User::find($user_id);
                    $initUser = auth()->user();
                    if ($user){

                        $number = $user->ban_chat;
                        $amount = 5 * $number;

                        $balance = $initUser->gas_balance;
                        // перевіряємо чи достатньо газів на балансі
                        if ($balance >= $amount){

                            $data = [
                                'user_id' => $initUser->id,
                                'outgoing' => $amount,
                                'description' => "Розбан пользователя #$user->id($user->name)"
                            ];

                            // створюємо транзакцію для списання газів
                            $transaction = new GasTransaction($data);
                            $initUser->gas_transactions()->save($transaction);

                            // обнуляємо кількість повідомлень для бана в БД
                            $user->ban_chat = 0;
                            $user->save();

                            // визвати подію, яка верне розбаненого юзера( id, name, number)
                            $dataEvent = [
                                'user_id' => $user->id,
                                'name' => $user->name,
                            ];
                            event(new UnBanUserChat($dataEvent));

                            // записати меседж в базу про зміну імені
                            $message_data['message'] = "Пользователь #$initUser->id($initUser->name) розбанил пользователя #$user->id($user->name)";
                            $message = $this->saveMessage($message_data);
                            if ($message){
                                // відправити респонс про успішне виконання команди
                                // echo 'message збережено';
                                return response()->json([
                                    'status' => true,
                                    'message' => 'Success',
                                    'is_command' => true,
                                    'data'   => [
                                        'model' => $message,
                                    ],
                                ], 200);
                            }else{
                                // echo 'message помилка збереження';
                                return response()->json([
                                    'status' => false,
                                    'message' => 'No save message'
                                ], 500);
                            }
                        }else{
                            return response()->json([
                                'status' => false,
                                'message' => 'No gas balance'
                            ], 404);
                        }
                    }
                    return response()->json([
                        'status' => false,
                        'message' => 'Not found user'
                    ], 404);
                }else{
                    return response()->json([
                        'status' => false,
                        'message' => 'Error command argument'
                    ], 404);
                }
                break;

            case '/tr':
                $pattern = "/(?P<comand>^\/tr\b) (?P<userid>\d+) (?P<amount>\d+)/i";

                if(preg_match($pattern, $request->message,$matches)){

                    $user_id = $matches['userid'];
                    $amount = $matches['amount'];

                    $user = User::find($user_id);
                    $initUser = auth()->user();
                    if ($user){

                        if ($user->id == $initUser->id){
                            return response()->json([
                                'status' => false,
                                'message' => 'Transfer gas to yourself'
                            ], 403);
                        }

                        $balance = $initUser->gas_balance;
                        // перевіряємо чи достатньо газів на балансі
                        if ($balance >= $amount){

                            $data = [
                                'user_id' => $initUser->id,
                                'outgoing' => $amount,
                                'description' => "Передача газа пользователю #$user->id($user->name)"
                            ];

                            // створюємо транзакцію для списання газів
                            $transaction = new GasTransaction($data);
                            $initUser->gas_transactions()->save($transaction);

                            // створюємо транзакцію для нарахування газів
                            $data = [
                                'user_id' => $user->id,
                                'incoming' => $amount,
                                'description' => "Получение газа от пользователя #$initUser->id($initUser->name)"
                            ];
                            $transaction = new GasTransaction($data);
                            $initUser->gas_transactions()->save($transaction);

                            // записати меседж в базу про зміну імені
                            $message_data['message'] = "Пользователь #$initUser->id($initUser->name) передал $amount gas для #$user->id($user->name)";
                            $message = $this->saveMessage($message_data);
                            if ($message){
//                             echo 'message збережено';
                                return response()->json([
                                    'status' => 'ok',
                                    'is_command' => true,
                                    'data'   => [
                                        'model' => $message,
                                    ],
                                ], 200);
                            }else{
                                // echo 'message помилка збереження';
                                return response()->json([
                                    'status' => false,
                                    'message' => 'No save message'
                                ], 500);
                            }

                            // відправити респонс про успішне виконання команди

                        }else{
                            return response()->json([
                                'status' => false,
                                'message' => 'No gas balance'
                            ], 404);
                        }
                    }
                    return response()->json([
                        'status' => false,
                        'message' => 'Not found user'
                    ], 404);
                }else{
                    return response()->json([
                        'status' => false,
                        'message' => 'Error command argument'
                    ], 404);
                }
                break;

            case '/anon':
                $strlen = strlen($request->message);
                $message = substr($request->message, 5,$strlen);

                if ($message){

                    $message = clean($message);
                    if (empty($message)) {
                        return response()->json([
                            'status' => false,
                            'message' => 'No message'
                        ], 404);
                    }

                    $user = auth()->user();
                    $balance = $user->gas_balance;
                    $amount = 10;
                    if ($balance >= $amount){

                        $data = [
                            'user_id' => $user->id,
                            'outgoing' => $amount,
                            'description' => "Отправка анонимного сообщения"
                        ];

                        // створюємо транзакцію для списання газів
                        $transaction = new GasTransaction($data);
                        $user->gas_transactions()->save($transaction);

                        // записати меседж в базу
                        $message_data['message'] = $message;
                        $message = $this->saveMessage($message_data,true);
                        if ($message){
//                             echo 'message збережено';
                            return response()->json([
                                'status' => 'ok',
                                'is_command' => true,
                                'data'   => [
                                    'model' => $message,
                                ],
                            ], 200);
                        }else{
                            // echo 'message помилка збереження';
                            return response()->json([
                                'status' => false,
                                'message' => 'No save message'
                            ], 500);
                        }

                        // відправити респонс про успішне виконання команди

                    }else{
                        return response()->json([
                            'status' => false,
                            'message' => 'No gas balance'
                        ], 404);
                    }
                }else{
                    return response()->json([
                        'status' => false,
                        'message' => 'No message'
                    ], 404);
                }
                break;

            case '/sb':
                $pattern = "/(?P<comand>^\/sb\b) (?P<player1>\w+) (?P<k1>\d+) (?P<k2>\d+) (?P<player2>\w+) (?P<amount>\d+)$/i";

                if(preg_match($pattern, $request->message,$matches)){

                    $player1 = $matches['player1'];
                    $player2 = $matches['player2'];
                    $k1 = $matches['k1'];
                    $k2 = $matches['k2'];
                    $amount = $matches['amount'];

                    $author = auth()->user();



                    //провіряємо чи є активні ставки
                    if (!$author->hasActiveBet())
                    {
                        // провіряємо баланс
                        if ($author->gas_balance >= $amount){
                            //створюємо ставку
                            $bet = Bet::create([
                                'author_id' => $author->id,
                                'player1' => $player1,
                                'player2' => $player2,
                                'coefficient1' => $k1,
                                'coefficient2' => $k2,
                                'amount' => $amount
                            ]);

                            // додаємо автора ставки в сделку
                            $deal = Deal::create([
                                'user_id' => $author->id,
                                'bet_id' => $bet->id,
                                'amount' => $amount
                            ]);

                            // створюємо транзакцію для списання газів
                            $data = [
                                'user_id' => $author->id,
                                'outgoing' => $amount,
                                'description' => "Создание ставки $bet->name"
                            ];
                            $transaction = new GasTransaction($data);
                            $bet->gas_transactions()->save($transaction);

                            // записати меседж в базу про створення ставки
                            $message_data['message'] = "Пользователь #$author->id($author->name) создал ставку $bet->name";
                            $message = $this->saveMessage($message_data);
                            if ($message){
                                // відправити респонс про успішне виконання команди
                                // echo 'message збережено';
                                return response()->json([
                                    'status' => true,
                                    'message' => 'Success',
                                    'is_command' => true,
                                    'data'   => [
                                        'model' => $message,
                                    ],
                                ], 200);
                            }else{
                                // echo 'message помилка збереження';
                                return response()->json([
                                    'status' => false,
                                    'message' => 'No save message'
                                ], 500);
                            }

                        }else{
                            return response()->json([
                                'status' => false,
                                'message' => 'No gas balance'
                            ], 404);
                        }
                    }else{
                        return response()->json([
                            'status' => false,
                            'message' => 'Have active bet'
                        ], 404);
                    }

                }else{
                    return response()->json([
                        'status' => false,
                        'message' => 'Error command argument'
                    ], 404);
                }
                break;

            case '/bet':
                $pattern = "/(?P<comand>^\/bet\b) (?P<player1>\w+) (?P<player2>\w+) (?P<amount>\d+)$/i";

                if(preg_match($pattern, $request->message,$matches)){

                    $player1 = $matches['player1'];
                    $player2 = $matches['player2'];
                    $k1 = 1;
                    $k2 = 1;
                    $amount = $matches['amount'];

                    $author = auth()->user();



                    //провіряємо чи є активні ставки
                    if (!$author->hasActiveBet())
                    {
                        // провіряємо баланс
                        if ($author->gas_balance >= $amount){
                            //створюємо ставку
                            $bet = Bet::create([
                                'author_id' => $author->id,
                                'player1' => $player1,
                                'player2' => $player2,
                                'coefficient1' => $k1,
                                'coefficient2' => $k2,
                                'amount' => $amount
                            ]);

                            // додаємо автора ставки в сделку
                            $deal = Deal::create([
                                'user_id' => $author->id,
                                'bet_id' => $bet->id,
                                'amount' => $amount
                            ]);

                            // створюємо транзакцію для списання газів
                            $data = [
                                'user_id' => $author->id,
                                'outgoing' => $amount,
                                'description' => "Создание ставки $bet->name"
                            ];
                            $transaction = new GasTransaction($data);
                            $bet->gas_transactions()->save($transaction);

                            // записати меседж в базу про створення ставки
                            $message_data['message'] = "Пользователь #$author->id($author->name) создал ставку $bet->name";
                            $message = $this->saveMessage($message_data);
                            if ($message){
                                // відправити респонс про успішне виконання команди
                                // echo 'message збережено';
                                return response()->json([
                                    'status' => true,
                                    'message' => 'Success',
                                    'is_command' => true,
                                    'data'   => [
                                        'model' => $message,
                                    ],
                                ], 200);
                            }else{
                                // echo 'message помилка збереження';
                                return response()->json([
                                    'status' => false,
                                    'message' => 'No save message'
                                ], 500);
                            }

                        }else{
                            return response()->json([
                                'status' => false,
                                'message' => 'No gas balance'
                            ], 404);
                        }
                    }else{
                        return response()->json([
                            'status' => false,
                            'message' => 'Have active bet'
                        ], 404);
                    }

                }else{
                    return response()->json([
                        'status' => false,
                        'message' => 'Error command argument'
                    ], 404);
                }
                break;

            case '/deal':
                $pattern = "/(?P<comand>^\/deal\b) (?P<betid>\d+) (?P<amount>\d+)$/i";

                if(preg_match($pattern, $request->message,$matches)){

                    $bet_id = $matches['betid'];
                    $amount = $matches['amount'];

                    $user = auth()->user();

                    $bet = Bet::find($bet_id);

                    //провіряємо чи є ставка
                    if ($bet)
                    {
                        // перевіряємо на автора ставки
                        if ($bet->author_id == $user->id){
                            return response()->json([
                                'status' => false,
                                'message' => 'Your author bet'
                            ], 403);
                        }
                        // перевіряємо чи юзер вже приймав ставку
                        $deals = $bet->deals()->get();
                        if ($deals->contains('user_id', $user->id)){
                            return response()->json([
                                'status' => false,
                                'message' => 'User has already accepted the bid'
                            ], 403);
                        }

                        // cума сделки не повинна перевищувати ставку
                        if ($amount > $bet->amount){
                            $amount = $bet->amount;
                        }

                        // провіряємо баланс
                        if ($user->gas_balance >= $amount){

                            //створюємо сделку
                            $deal = Deal::create([
                                'user_id' => $user->id,
                                'bet_id' => $bet->id,
                                'amount' => $amount
                            ]);


                            // створюємо транзакцію для списання газів
                            $data = [
                                'user_id' => $user->id,
                                'outgoing' => $amount,
                                'description' => "Принятие ставки $bet->name в размере $amount gas"
                            ];
                            $transaction = new GasTransaction($data);
                            $bet->gas_transactions()->save($transaction);

                            // записати меседж в базу про створення ставки
                            $message_data['message'] = "Пользователь #$user->id($user->name) принял ставку $bet->name в размере $amount gas";
                            $message = $this->saveMessage($message_data);
                            if ($message){
                                // відправити респонс про успішне виконання команди
                                // echo 'message збережено';
                                return response()->json([
                                    'status' => true,
                                    'message' => 'Success',
                                    'is_command' => true,
                                    'data'   => [
                                        'model' => $message,
                                    ],
                                ], 200);
                            }else{
                                // echo 'message помилка збереження';
                                return response()->json([
                                    'status' => false,
                                    'message' => 'No save message'
                                ], 500);
                            }

                        }else{
                            return response()->json([
                                'status' => false,
                                'message' => 'No gas balance'
                            ], 404);
                        }
                    }else{
                        return response()->json([
                            'status' => false,
                            'message' => 'Not found bet'
                        ], 404);
                    }

                }else{
                    return response()->json([
                        'status' => false,
                        'message' => 'Error command argument'
                    ], 404);
                }
                break;

            case '/win':
                $pattern = "/(?P<comand>^\/win\b) (?P<userid>\d+)$/i";

                if(preg_match($pattern, $request->message,$matches)){

                    $user_id = $matches['userid'];

                    $author = auth()->user();

                    $user = User::find($user_id);
                    if ($user){

                        // перемога автора


                        $activeBet = $author->bets()->active()->latest()->first();
                        if (!$activeBet){
                            return response()->json([
                                'status' => false,
                                'message' => 'Not found active bet'
                            ], 404);
                        }

                        // провіряємо чи приймав юзер ставку
                        $deals = $activeBet->deals()->get();
                        if (!$deals->contains('user_id', $user->id)){
                            return response()->json([
                                'status' => false,
                                'message' => 'User did not accept bid'
                            ], 404);
                        }

                        $winnerDeal = $deals->first(function ($value, $key) use($user){
                            return $value->user_id == $user->id;
                        });

                        // записываем победителя и закрываем ставку
                        $activeBet->winner_id = $user->id;
                        $activeBet->status = false;
                        $activeBet->save();

                        // нараховуємо виграш
                        // $amount = сума * к2/к1
                        $amount = $winnerDeal->amount * $activeBet->coefficient2 / $activeBet->coefficient1;
                        $data = [
                            'user_id' => $winnerDeal->user_id,
                            'incoming' => $amount,
                            'description' => "Выиграш по ставке $activeBet->name"
                        ];
                        $transaction = new GasTransaction($data);
                        $activeBet->gas_transactions()->save($transaction);

                        // записати меседж в базу про створення ставки
                        $message_data['message'] = "Пользователь #$user->id($user->name) выиграл ставку $activeBet->name";
                        $message = $this->saveMessage($message_data);
                        if ($message){
                            // відправити респонс про успішне виконання команди
                            // echo 'message збережено';
                            return response()->json([
                                'status' => true,
                                'message' => 'Success',
                                'is_command' => true,
                                'data'   => [
                                    'model' => $message,
                                ],
                            ], 200);
                        }else{
                            // echo 'message помилка збереження';
                            return response()->json([
                                'status' => false,
                                'message' => 'No save message'
                            ], 500);
                        }


                    }
                    return response()->json([
                        'status' => false,
                        'message' => 'Not found user'
                    ], 404);

                }else{
                    return response()->json([
                        'status' => false,
                        'message' => 'Error command argument'
                    ], 404);
                }
                break;
            default:
                // якщо не має команди просто зберігаємо повідомлення
                $message = clean($request->message);
                if (empty($message)) {
                    return response()->json([
                        'status' => false,
                        'message' => 'No message'
                    ], 404);
                }

                // записати меседж в базу
                $message_data['message'] = $message;
                $message = $this->saveMessage($message_data);
                if ($message){
//                             echo 'message збережено';
                    return response()->json([
                        'status' => 'ok',
                        'is_command' => true,
                        'data'   => [
                            'model' => $message,
                        ],
                    ], 200);
                }else{
                    // echo 'message помилка збереження';
                    return response()->json([
                        'status' => false,
                        'message' => 'No save message'
                    ], 500);
                }

        }

//        dd($command);

//        if (Auth::id() == $request->user_id) {
//            $message_data['user_name'] = Auth::user()->name;
            //            $message_data['message'] = $this->chat_helper->rewrapperText($message_data['message']);

//            $message = clean($request->message);
//            if (empty($message)) {
//                return response()->json([
//                    'status' => 'fail',
//                ], 200);
//            }
//            $message_data['message'] = $message;
//            $message_data['to']      = $this->selected_user;
//            $insert                  = PublicChat::create($message_data);
//
//            if ($insert) {
//                $insert->load('user');
//                $resultModel = $this->setFullMessage($insert);
//                event(new NewChatMessageAdded($resultModel));
//
//                return response()->json([
//                    'status' => 'ok',
//                    'data'   => $resultModel, 'user' => Auth::id(),
//                ], 200);
//            }
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Forbidden'
            ], 403);
        }
    }

    public function saveMessage($data, $isAnon = false){
        $data['user_name']  = Auth::user()->name;
        $data['to']         = $this->selected_user;
        $data['is_anon']    = $isAnon;
        $model             = PublicChat::create($data);
        if ($model) {
            $model->load('user');
            $resultModel = $this->setFullMessage($model);
            event(new NewChatMessageAdded($resultModel));
            event(new CheckNewMessage());
            return $resultModel;
        }
        return false;

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
        if ($msg->is_anon){
            $user_id = 'anon';
            $user_name = 'anon';
            $avatar = 'images/default/avatar/avatar.png';
        }else{
            $user_id = $msg->user_id;
            $user_name = $msg->user_name;
            $avatar = isset($msg->user->avatar) ? $msg->user->avatar : 'images/default/avatar/avatar.png';
        }

        return [
            'id'           => $msg->id,
            'user_id'      => $user_id,
            'user_name'    => $user_name,
            'message'      => clean($msg->message),
            'to'           => $msg->to,
            'file_path'    => $msg->file_path,
            'imo'          => $msg->imo,
            'created_at'   => $msg->created_at,
            'time'         => $msg->created_at->format('H:i'),
            'country_flag' => $country_flag,
            'is_hidden'    => $msg->is_hidden,
            'avatar'       => $avatar,
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

    public function separate_window(){
        return view('chat.separate_window');
    }



}
