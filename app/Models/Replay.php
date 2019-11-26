<?php

namespace App\Models;

use App\Traits\ModelRelations\ReplayRelationTrait;
use Eloquent;
use Illuminate\Database\Eloquent\Model;
use Staudenmeir\EloquentEagerLimit\HasEagerLimit;
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

            'user_id',
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
            'approved',
            'first_location',
            'first_name',
            'first_apm',
            'second_location',
            'second_name',
            'second_apm',
            'content',
            'video_iframe',
            'downloaded',
            'start_date',
            'file',

        ];

    /**
     * Get all of the comments for the User Replay.
     */
    public function replayUserComments()
    {
        return $this->hasManyThrough(
            'App\Models\Comment',
            'App\User',
            'id',
            'user_id',
            'user_id',
            'id'
        );

    }

    public static function checkUser4Update(){
        /*User role cannot add PRO-Replay*/
        if (request('user_replay') == Replay::REPLAY_PRO) {
            if (auth()->user()->isUser()) {
                return back();
            }
        }
        return null;
    }
}
