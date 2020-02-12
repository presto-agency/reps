<?php

namespace App\Models;


use App\Traits\ModelRelations\UserActivityLogRelationTrait;
use Illuminate\Database\Eloquent\Model;

class UserActivityLog extends Model
{

    use UserActivityLogRelationTrait;

    const EVENT_USER_VERIFIED = 'verified';
    const EVENT_USER_VERIFIED_VAL = 0;

    const EVENT_USER_LOGIN = 'login';
    const EVENT_USER_LOGIN_VAL = 1;

    const EVENT_USER_LOGOUT = 'logout';
    const EVENT_USER_LOGOUT_VAL = 2;


    const EVENT_USER_COMMENT = 'comment';
    const EVENT_USER_COMMENT_VAL = 3;


    const EVENT_USER_LIKE = 'like';
    const EVENT_USER_LIKE_VAL = 4;


    const EVENT_USER_REGISTER = 'register';
    const EVENT_USER_REGISTER_VAL = 5;


    const EVENT_USER_REGISTER_CONFIRM = 'register_confirm';
    const EVENT_USER_REGISTER_CONFIRM_VAL = 6;


    const EVENT_CREATE_POST = 'create_post';
    const EVENT_CREATE_POST_VAL = 7;


    const EVENT_CREATE_REPLAY = 'create_replay';
    const EVENT_CREATE_REPLAY_VAL = 8;


    const EVENT_CREATE_IMAGE = 'create_image';
    const EVENT_CREATE_IMAGE_VAL = 9;


    public static $eventType
        = [
            self::EVENT_USER_VERIFIED         => self::EVENT_USER_VERIFIED,
            self::EVENT_USER_LOGIN            => self::EVENT_USER_LOGIN,
            self::EVENT_USER_LOGOUT           => self::EVENT_USER_LOGOUT,
            self::EVENT_USER_COMMENT          => self::EVENT_USER_COMMENT,
            self::EVENT_USER_LIKE             => self::EVENT_USER_LIKE,
            self::EVENT_USER_REGISTER         => self::EVENT_USER_REGISTER,
//            self::EVENT_USER_REGISTER_CONFIRM => self::EVENT_USER_REGISTER_CONFIRM,
            self::EVENT_CREATE_POST           => self::EVENT_CREATE_POST,
            self::EVENT_CREATE_REPLAY         => self::EVENT_CREATE_REPLAY,
            self::EVENT_CREATE_IMAGE          => self::EVENT_CREATE_IMAGE,
        ];

    protected $guarded
        = [
            'type',
            'user_id',
            'time',
            'ip',
            'parameters',
        ];


}
