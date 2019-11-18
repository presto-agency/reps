<?php

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

/*Broadcast::channel('App.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});*/

Broadcast::channel('dialogue.{room_id}', function ($user, $room_id) {

    //делаем проверку может ли пользователь входить в комнату
    // обращаемся к пользователю который пытается подключится
    // и ищем связаные комнаты с этим пользователем
    // contains() ищет значение в колекции по номеру комнаты к которай пытается подключится пользователь
//    return $user->rooms->contains($room_id);
    return true;
});
