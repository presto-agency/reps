<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\ModelRelations\ReplayRelationTrait;

class Replay extends Model
{
    use ReplayRelationTrait;

    const REPLAY_PRO = 0;
    const REPLAY_USER = 1;

    public static $userReplaysType = [
        0 => 'Профессиональный',
        1 => 'Пользовательский',
    ];
    protected $fillable = [

        'user_id',
        'title',
        'map_id',
        'first_country_id', 'second_country_id',
        'first_race', 'second_race',
        'type_id',
        'comments_count',
        'user_rating',
        'negative_count', 'rating', 'positive_count',
        'approved',
        'first_location',
        'first_name',
        'first_apm',
        'second_location',
        'second_name',
        'second_apm',
        'content',
        'downloaded',
        'start_date',
        'file',

    ];

}
