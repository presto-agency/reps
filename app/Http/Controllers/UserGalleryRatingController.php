<?php

namespace App\Http\Controllers;

use App\Models\UserGallery;
use App\Models\UserReputation;
use Illuminate\Http\Request;

class UserGalleryRatingController extends RatingController
{
    /**
     * Object relation
     *
     * @var string
     */
    protected $relation = UserReputation::RELATION_USER_GALLERY;

    /**
     * Model name
     *
     * @var string
     */
    protected $model = UserGallery::class;
}
