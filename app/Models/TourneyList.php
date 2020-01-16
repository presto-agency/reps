<?php

namespace App\Models;


use App\Traits\ModelRelations\TournamentRelationTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class TourneyList extends Model
{

    use Notifiable, TournamentRelationTrait;

    /**
     * var array
     */

    const YES = 1;

    CONST NO = 2;

    public static $status4Select
        = [
            3 => 'GENERATION', 5 => 'FINISHED',
        ];
    public static $status
        = [
            0 => 'ANNOUNCE', 1 => 'REGISTRATION', 2 => 'CHECK-IN',
            3 => 'GENERATION', 4 => 'STARTED', 5 => 'FINISHED',
        ];


    public static $map_types
        = [
            0 => 'NONE', 1 => 'FIRSTBYREMOVING', 2 => 'FIRSTBYROUND',
        ];


    public static $yesOrNo
        = [
            self::NO => 'No', self::YES => 'Yes',
        ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded
        = [
            'name',
            'place',
            'prize_pool',
            'rules_link',
            'vod_link',
            'logo_link',
            'password',
            'all_file',
            'status',
            'map_select_type',
            'visible',
            'ranking',
            'reg_time',
            'checkin_time',
            'start_time',
            'importance',
            'user_id',
        ];

    protected $casts
        = [
            'name'            => 'string',
            'place'           => 'string',
            'prize_pool'      => 'string',
            'rules_link'      => 'string',
            'vod_link'        => 'string',
            'logo_link'       => 'string',
            'password'        => 'string',
            'all_file'        => 'string',
            'status'          => 'int',
            'map_select_type' => 'int',
            'user_id'         => 'int',
            'importance'      => 'int',
            'visible'         => 'int',
            'ranking'         => 'int',

        ];


}
