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
}
