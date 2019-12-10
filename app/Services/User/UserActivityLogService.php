<?php

namespace App\Services\User;


use App\Models\Comment;
use App\Models\Replay;
use App\Models\UserReputation;

class UserActivityLogService
{


    public static function parametersForCreateImage($userGallery)
    {


        if ($userGallery->getTitle()) {
            $route = route('user-gallery.show', [
                'id' => $userGallery->user_id,
                'user_gallery' => $userGallery->id,
            ]);
            $description = 'Изображение <a target="_blank" href="' . asset($route) . '">' . $userGallery->getTitle() . '</a>';
        } else {
            $route = route('user-gallery.show', [
                'id' => $userGallery->user_id,
                'user_gallery' => $userGallery->id,
            ]);
            $description = '<a target="_blank" href="' . asset($route) . '">Изображение</a>';
        }

        return json_encode(['description' => $description]);
    }


    public static function parametersForCreateReplay($replay)
    {
        $type = Replay::$type[$replay->user_replay];
        $route = "replay/{$replay->id}" . "?type=$type";
        $description = 'Replay <a target="_blank" href="' . asset($route) . '">' . $replay->title . '</a>';
        return json_encode(['description' => $description,]);
    }

    public static function parametersForCreateTopic($forumTopic)
    {
        $route = route('topic.show', ['topic' => $forumTopic->id]);
        $description = 'Пост <a target="_blank" href="' . asset($route) . '">' . $forumTopic->title . '</a>';
        return json_encode(['description' => $description,]);
    }

    public static function parametersForComment($comment)
    {
        $userName = $comment->user->name;
        $route = self::getCommentRoute($comment);
        $title = self::getCommentTitle($comment);
        $description = 'Комментарий от ' . $userName . ' для <a target="_blank" href="' . asset($route) . '">' . $title . '</a>';

        return json_encode(['description' => $description,]);
    }

    public static function getCommentRoute($comment)
    {
        switch ($comment->commentable_type) {
            case Comment::RELATION_FORUM_TOPIC:
            {
                return self::getTopicShowRoute($comment->commentable->id);
            }
            case Comment::RELATION_REPLAY:
            {
                return self::getReplayShowRoute($comment->commentable->id, $comment->commentable->user_replay);
            }
            case Comment::RELATION_USER_GALLERY:
            {
                return self::getUserGalleryShowRoute($comment->commentable->user_id, $comment->commentable->id);
            }
            default:
            {
                return null;
            }
        }
    }

    public static function getCommentTitle($comment)
    {
        switch ($comment->commentable_type) {
            case Comment::RELATION_FORUM_TOPIC:
            {
                return $comment->commentable->title;
            }
            case Comment::RELATION_REPLAY:
            {
                return $comment->commentable->title;
            }
            case Comment::RELATION_USER_GALLERY:
            {
                return $comment->commentable->sign;
            }
            default:
            {
                return null;
            }
        }
    }

    public static function parametersForLike($userReputation)
    {

        $sender = $userReputation->sender;
        $senderName = $sender->name;
        $routSender = route('user_profile', ['id' => $sender->id]);
        $route = self::getLikeRoute($userReputation);
        $title = self::getLikeTitle($userReputation);

        $part = $userReputation->relation == UserReputation::RELATION_COMMENT ? 'Лайк комментария от' : 'Лайк от';

        $description = $part . ' <a target="_blank" href="' . asset($routSender) . '">' . $senderName . '</a> для <a target="_blank" href="' . asset($route) . '">' . $title . '</a>';


        return json_encode(['description' => $description,]);
    }

    public static function getLikeRoute($userReputation)
    {

        switch ($userReputation->relation) {
            case UserReputation::RELATION_FORUM_TOPIC:
            {
                return self::getTopicShowRoute($userReputation->topic->id);
            }
            case UserReputation::RELATION_REPLAY:
            {
                return self::getReplayShowRoute($userReputation->replay->id, $userReputation->replay->user_replay);
            }
            case UserReputation::RELATION_USER_GALLERY:
            {
                return self::getUserGalleryShowRoute($userReputation->gallery->user_id, $userReputation->gallery->id);
            }
            case UserReputation::RELATION_COMMENT:
            {
                return self::getCommentRoute($userReputation->commentRelation);
            }
            default:
            {
                return null;
            }
        }
    }

    public static function getLikeTitle($userReputation)
    {

        switch ($userReputation->relation) {
            case UserReputation::RELATION_FORUM_TOPIC:
            {
                return $userReputation->topic->title;
            }
            case UserReputation::RELATION_REPLAY:
            {
                return $userReputation->replay->title;
            }
            case UserReputation::RELATION_USER_GALLERY:
            {
                return $userReputation->gallery->sign;
            }
            case UserReputation::RELATION_COMMENT:
            {
                return self::getCommentTitle($userReputation->commentRelation);
            }
            default:
            {
                return null;
            }
        }
    }

    public static function getTopicShowRoute($topicId)
    {
        return route('topic.show', $topicId);
    }

    public static function getReplayShowRoute($replayId, $userReplay)
    {
        $type = Replay::$type[$userReplay];
        return "replay/{$replayId}" . "?type=$type";
    }

    public static function getUserGalleryShowRoute($userId, $id)
    {
        return route('user-gallery.show', ['id' => $userId, 'user_gallery' => $id]);
    }

}
