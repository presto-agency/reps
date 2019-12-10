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

    public function getRating($id){

        $object = $this->model::where('id',$id)->withCount('comments')->first();

        if ($object){
            $list = UserReputation::where('object_id', $object->id)->where('relation', $this->relation)->with('sender.races')->get();
            $route = '';
            return view('user.rating-list.index-topic', compact('object', 'list', 'route'));
        }
        abort(404);
    }
}
