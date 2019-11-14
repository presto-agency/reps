<?php

namespace App\Services\User;


class UserActivityLogService
{


    public static function parametersForCreateImage($userGallery)
    {
        if ($userGallery->getTitle()) {
            $description =
                'Изображение <a target="_blank" href="' . route('user-gallery.show',
                    [
                        'id'           => $userGallery->user_id,
                        'user_gallery' => $userGallery->id
                    ]) . '">' . $userGallery->getTitle() . '</a>';
        } else {
            $description = '<a target="_blank" href="' . route('user-gallery.show',
                    ['id'           => $userGallery->user_id,
                     'user_gallery' => $userGallery->id
                    ]) . '">Изображение</a>';
        }

        return json_encode(['description' => $description]);
    }


    public static function parametersForCreateReplay($replay)
    {
        return json_encode(['description' => 'Replay <a target="_blank" href="' . route('replay.show', ['replay' => $replay->id]) . '">' . $replay->title . '</a>']);
    }

    public static function parametersForCreateTopic($forumTopic)
    {
        return json_encode(['description' => 'Пост <a target="_blank" href="' . route('topic.show', ['topic' => $forumTopic->id]) . '">' . $forumTopic->title . '</a>']);
    }

//    const EVENT_USER_LOGIN = 'login';
//    const EVENT_USER_LOGOUT = 'logout';
//    const EVENT_USER_COMMENT = 'comment';
//    const EVENT_USER_LIKE = 'like';
//    const EVENT_USER_REGISTER = 'register';
//    const EVENT_USER_REGISTER_CONFIRM = 'register_confirm';
//    const EVENT_CREATE_POST = 'create_post';
//    const EVENT_CREATE_REPLAY = 'create_replay';
//    const EVENT_CREATE_IMAGE = 'create_image';
//
//    protected static $eventTypeArgumentHandler = [
//        self::EVENT_USER_LOGIN => 'parametersForLogin',
//        self::EVENT_USER_LOGOUT => 'parametersForLogout',
//        self::EVENT_USER_COMMENT => 'parametersForComment',
//        self::EVENT_USER_LIKE => 'parametersForLike',
//        self::EVENT_USER_REGISTER => 'parametersForRegister',
//        self::EVENT_USER_REGISTER_CONFIRM => 'parametersForRegisterConfirm',
//        self::EVENT_CREATE_POST => 'parametersForCreatePost',
//        self::EVENT_CREATE_REPLAY => 'parametersForCreateReplay',
//        self::EVENT_CREATE_IMAGE => 'parametersForCreateImage'
//    ];
//
//    public static function log($type, $targetObject = null, $userId = null)
//    {
//        //get parameters from target object
//
//        //save log entry
//
//        //TODO make validation of parameters
//
//        $handler = self::$eventTypeArgumentHandler[$type];
//
//        $newLogEntry = new UserActivityLogEntry([
//            'type' => $type,
//            'time' => new \DateTime(),
//            'user_id' => $userId ? : Auth::id(),
//            'parameters' => self::$handler($targetObject),
//            'ip' => \Illuminate\Support\Facades\Request::ip() ? : ''
//        ]);
//
//        $newLogEntry->save();
//    }
//
//    public static function searchLogs(Request $request)
//    {
//        $logsQuery = UserActivityLogEntry::with('user');
//
//        if ($request->has('type') && null !== $request->get('type')){
//            $logsQuery->where('type', '=', $request->get('type'));
//        }
//
//        if ($request->has('user_id') && null !== $request->get('user_id')){
//            $logsQuery->where('user_id', '=', $request->get('user_id'));
//        }
//
//        if ($request->has('start')) {
//            $startTime = $request->get('start') . ' 00:00:00';
//            $logsQuery->where('time', '>=', $startTime);
//        }
//
//        if ($request->has('end')) {
//            $endTime = $request->get('end') . ' 23:59:59';
//            $logsQuery->where('time', '<=', $endTime);
//        }
//
//        if ($request->has('ip')) {
//            $logsQuery->where('ip', 'LIKE', '%'.$request->get('ip').'%');
//        }
//
//        if($request->has('sort') && null !==$request->get('sort')){
//            $logsQuery->orderBy($request->get('sort'));
//        } else{
//            $logsQuery->orderBy('time', 'desc');
//        }
//
//        return $logsQuery;
//    }
//
//    public static function getEventTypes()
//    {
//        return [
//            self::EVENT_USER_LOGIN,
//            self::EVENT_USER_LOGOUT,
//            self::EVENT_USER_COMMENT,
//            self::EVENT_USER_LIKE,
//            self::EVENT_USER_REGISTER,
//            self::EVENT_USER_REGISTER_CONFIRM,
//            self::EVENT_CREATE_POST,
//            self::EVENT_CREATE_REPLAY,
//            self::EVENT_CREATE_IMAGE,
//        ];
//    }
//
//    private static function parametersForLogin()
//    {
//        return null;
//    }
//
//    private static function parametersForLogout()
//    {
//        return null;
//    }

//    public static function parametersForComment(Comment $comment)
//    {
//        $routeConfig = $comment->getCommentContainer()->getRouteConfig();
//        $title = $comment->getCommentContainer()->getTitle();
//
//        $link = route($routeConfig[0], $routeConfig[1]);
//
//        return [
//            'description' => 'Комментарий для <a target="_blank" href="' . $link . '">' . ($title ?: $link) . '</a>'
//        ];
//    }
//
//    public static function parametersForLike(UserReputation $like)
//    {
//        $likedObject = $like->getObject();
//
//        $likedUser = $like->recipient;
//        $likedUserName = $likedUser->name;
//        $likedUser = route('admin.user.profile', ['id' => $likedUser->id]);
//
//        if ($likedObject instanceof Comment) {
//            $routeConfig = $likedObject->getCommentContainer()->getRouteConfig();
//            $title = $likedObject->getCommentContainer()->getTitle();
//
//            $link = route($routeConfig[0], $routeConfig[1]);
//
//            $description = 'Лайк комментария <a target="_blank" href="' . $likedUser . '">' . $likedUserName . '</a> для <a target="_blank" href="' . $link . '">' . ($title ?: $link) . '</a>';
//        } else {
//            $routeConfig = $likedObject->getRouteConfig();
//            $title = $likedObject->getTitle();
//
//            $link = route($routeConfig[0], $routeConfig[1]);
//
//            $description = 'Лайк <a target="_blank" href="' . $likedUser . '">' . $likedUserName . '</a> для <a target="_blank" href="' . $link . '">' . ($title ?: $link) . '</a>';
//        }
//
//        return [
//            'description' => $description
//        ];
//    }


}
