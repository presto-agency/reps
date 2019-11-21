<?php

namespace App\Http\Controllers;

use App\Http\Requests\SetRatingRequest;
use App\Services\Rating\RatingService;
use Illuminate\Http\Request;

class RatingController extends Controller
{
    /**
     * Object relation
     *
     * @var string
     */
    protected $relation;

    /**
     * Model name
     *
     * @var string
     */
    protected $model;

    /**
     * Set rating
     *
     * @param SetRatingRequest $request
     * @param $id
     * @return array
     */
    public function setRating(SetRatingRequest $request, $id)
    {
        return RatingService::set($request, $id, $this->relation, $this->model);
    }

    /**
     * Get reputation of User
     *
     * @param $id
     * @return mixed
     */
    public function getRatingUser($id)
    {
        return RatingService::getRatingView($id);
    }
}
