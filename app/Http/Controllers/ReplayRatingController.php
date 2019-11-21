<?php

namespace App\Http\Controllers;

use App\Models\Replay;
use App\Models\UserReputation;
use Illuminate\Http\Request;

class ReplayRatingController extends RatingController
{
    /**
     * Object relation
     *
     * @var string
     */
    protected $relation = UserReputation::RELATION_REPLAY;

    /**
     * Model name
     *
     * @var string
     */
    protected $model = Replay::class;
}
