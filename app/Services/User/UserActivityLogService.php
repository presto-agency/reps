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
