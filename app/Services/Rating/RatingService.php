<?php
/**
 * Created by PhpStorm.
 * User: MAX
 * Date: 18.11.2019
 * Time: 12:38
 */

namespace App\Services\Rating;


use App\Events\UserLike;
use App\Http\Requests\SetRatingRequest;
use App\Models\Comment;
use App\Models\ForumTopic;
use App\Models\Replay;
use App\Models\UserGallery;
use App\Models\UserReputation;
use App\User;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class RatingService
{

    /**
     * Get user reputation view
     *
     * @param $id
     *
     * @return Factory|View
     */
    public static function getRatingView($id)
    {
        $user = User::findOrFail($id);
        $userReputations = null;

        return view('user.rating-list.index',
            compact('userReputations', 'user'));

        /*return view('user.reputation')->with([
            'user' => User::find($id)
        ]);*/
    }

    /**
     * Get view with rating list for current object
     *
     * @param $id
     * @param $relation
     * @param $model
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public static function getObjectRating($id, $model, $relation)
    {
        $route = '';
        $pagination_path = '';
        $object = $model::find($id);
        switch ($relation) {
            case UserReputation::RELATION_FORUM_TOPIC:
                $route = 'forum.topic.index';
                $pagination_path = 'forum.topic.paginate';
                break;
            case UserReputation::RELATION_REPLAY:
                $route = 'replay.get';
                $pagination_path = 'replay.paginate';
                break;
            case UserReputation::RELATION_USER_GALLERY:
                $route = 'gallery.view';
                $pagination_path = 'gallery.paginate';
                break;
        }
        return view('user.object-reputation')->with([
            'object' => $object,
            'route' => $route,
            'pagination_path' => $pagination_path
        ]);
    }

    /**
     * Refresh user Rating
     *
     * @param $user_id
     * @param $userReputation
     */
    public static function refreshUserRating($user_id, $userReputation)
    {
        event(new UserLike($userReputation));

        $positive = UserReputation::where('recipient_id', $user_id)
            ->where('rating', '1')->count();
        $negative = UserReputation::where('recipient_id', $user_id)
            ->where('rating', '-1')->count();
        $val = $positive - $negative;

        User::where('id', $user_id)->update([
            'rating' => $val,
            'count_negative' => $negative,
            'count_positive' => $positive,
        ]);
    }

    /**
     * Refresh object Rating
     *
     * @param $object_id
     * @param $relation_id
     * @param $userReputation
     */
    public static function refreshObjectRating($object_id, $relation_id)
    {

        $class_name = RatingService::getModel($relation_id);
        $positive = UserReputation::where('object_id', $object_id)
            ->where('relation', $relation_id)->where('rating',
                '1')->count();
        $negative = UserReputation::where('object_id', $object_id)
            ->where('relation', $relation_id)->where('rating',
                '-1')->count();
        $val = $positive - $negative;


        $class_name::where('id', $object_id)->update([
            'rating' => $val,
            'negative_count' => $negative,
            'positive_count' => $positive,
        ]);
    }

    /**
     * @param $relation_id
     *
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

    /**
     * Set rating
     *
     * @param SetRatingRequest $request
     * @param $id
     * @param $relation
     *
     * @return array
     */
    public static function set(
        Request $request,
        $id,
        $relation,
        $model
    )
    {
        $object = ($model)::find($id);

        $comment = self::getComment($request);
        if ($object) {
            if (!self::checkUserVoteExist($object, $request, $relation)) {
                $ratingObject = UserReputation::updateOrCreate(
                    [
                        'sender_id' => Auth::id(),
                        'recipient_id' => $object->user_id,
                        'object_id' => $object->id,
                        'relation' => $relation,
                    ],
                    ['comment' => $comment, 'rating' => $request->get('rating')]
                );

                //                UserActivityLogService::log(UserActivityLogService::EVENT_USER_LIKE, $ratingObject);

                return ['rating' => self::getRatingValue($object)];
            }

            return [
                'message' => 'Вы уже проголосовали, Ваш голос:',
                'user_rating' => $request->get('rating'),
            ];
        }

        return abort(404);
    }

    /**
     * Get comment value
     *
     * @param Request $request
     *
     * @return mixed|null
     */
    public static function getComment(Request $request)
    {
        $comment = null;

        if ($request->has('comment')) {
            $comment = $request->get('comment');
        }

        return $comment;
    }

    /**
     * @param $object
     * @param $request
     * @param $relation
     *
     * @return bool
     */
    public static function checkUserVoteExist($object, $request, $relation)
    {
        $vote = UserReputation::where('sender_id', Auth::id())
            ->where('recipient_id', $object->user_id)
            ->where('object_id', $object->id)
            ->where('relation', $relation)
            ->where('rating', $request->get('rating'))
            ->first();

        return $vote ? $vote : false;
    }

    /**
     * Get calculation of rating value
     *
     * @param $object
     *
     * @return mixed
     */
    protected static function getRatingValue($object)
    {
        return $object->positive()->count() - $object->negative()->count();
    }

}
