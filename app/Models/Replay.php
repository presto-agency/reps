<?php

namespace App\Models;

use App\Traits\ModelRelations\ReplayRelationTrait;
use Eloquent;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Replay
 *
 * @package App
 * @property  integer id
 * @mixin Eloquent
 */
class Replay extends Model
{

    use ReplayRelationTrait;

    const REPLAY_PRO = 0;

    const REPLAY_USER = 1;

    public static $userReplaysType
        = [
            Replay::REPLAY_PRO  => 'Профессиональный',
            Replay::REPLAY_USER => 'Пользовательский',
        ];

    public static $type
        = [
            Replay::REPLAY_PRO  => 'pro',
            Replay::REPLAY_USER => 'user',
        ];

    protected $fillable
        = [
            'title',
            'map_id',
            'first_country_id',
            'second_country_id',
            'first_race',
            'second_race',
            'type_id',
            'user_replay',
            'user_rating',
            'negative_count',
            'rating',
            'positive_count',
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
    protected $hidden
        = [
            'src_iframe',
        ];

    protected $guarded
        = [
            'user_id',
        ];

    /**
     * @param  int  $type_id
     * @param  int  $take
     *
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Query\Builder[]|\Illuminate\Support\Collection
     */
    public static function getNavigationReplays(int $type_id, int $take)
    {
        return Replay::with('types:id,name')
            ->where('approved', true)
            ->orderByDesc('id')
            ->withCount('comments')
            ->where('type_id', $type_id)
            ->take($take)
            ->get();
    }

}
