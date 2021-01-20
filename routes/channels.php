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

Broadcast::channel('dialogue.{id}', function ($user, $id) {

    //делаем проверку может ли пользователь входить в комнату
    // обращаемся к пользователю который пытается подключится
    // и ищем связаные комнаты с этим пользователем
    // contains() ищет значение в колекции по номеру комнаты к которай пытается подключится пользователь
    return $user->dialogues->contains($id);
});
