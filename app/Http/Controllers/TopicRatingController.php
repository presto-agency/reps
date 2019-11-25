<?php

namespace App\Http\Controllers;

use App\Models\ForumTopic;
use App\Models\UserReputation;
use Illuminate\Http\Request;

class TopicRatingController extends RatingController
{
    /**
     * Object relation
     *
     * @var string
     */
    protected $relation = UserReputation::RELATION_FORUM_TOPIC;

    /**
     * Model name
     *
     * @var string
     */
    protected $model = ForumTopic::class;

    public function getRating($id){

        $object = $this->model::where('id',$id)->withCount('comments')->first();

        if ($object){
            $list = UserReputation::where('object_id', $object->id)->where('relation', $this->relation)->with('sender.races')->get();
            $route = 'topic.show';
            return view('user.rating-list.index-topic', compact('object', 'list', 'route'));
        }
        abort(404);
    }
}
