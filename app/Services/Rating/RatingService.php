<?php
/**
 * Created by PhpStorm.
 * User: MAX
 * Date: 18.11.2019
 * Time: 12:38
 */

namespace App\Services\Rating;


use App\Models\Comment;
use App\Models\ForumTopic;
use App\Models\Replay;
use App\Models\UserGallery;
use App\Models\UserReputation;
use App\User;

class RatingService
{
    /**
     * Refresh user Rating
     *
     * @param $user_id
     */
    public static function refreshUserRating($user_id)
    {
        $positive = UserReputation::where('recipient_id', $user_id)->where('rating', '1')->count();
        $negative = UserReputation::where('recipient_id', $user_id)->where('rating', '-1')->count();
        $val = $positive - $negative;

        User::where('id', $user_id)->update([
            'rating' => $val,
            'count_negative' => $negative,
            'count_positive' => $positive
        ]);
    }

    /**
     * Refresh object Rating
     *
     * @param $object_id
     * @param $relation_id
     */
    public static function refreshObjectRating($object_id, $relation_id)
    {
        $class_name = RatingService::getModel($relation_id);
        $positive = UserReputation::where('object_id', $object_id)->where('relation', $relation_id)->where('rating',
            '1')->count();
        $negative = UserReputation::where('object_id', $object_id)->where('relation', $relation_id)->where('rating',
            '-1')->count();
        $val = $positive - $negative;

        $class_name::where('id', $object_id)->update([
            'rating' => $val,
            'count_negative' => $negative,
            'count_positive' => $positive
        ]);
    }

    /**
     * @param $relation_id
     * @return null|string
     */
    public static function getModel($relation_id)
    {
        $model = null;
        switch ($relation_id) {
            case UserReputation::RELATION_FORUM_TOPIC:
                $model = ForumTopic::class;
                break;
            case UserReputation::RELATION_REPLAY:
                $model = Replay::class;
                break;
            case UserReputation::RELATION_USER_GALLERY:
                $model = UserGallery::class;
                break;
            case UserReputation::RELATION_COMMENT:
                $model = Comment::class;
                break;
        }

        return $model;
    }
}