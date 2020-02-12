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
    const TYPE_SINGLE = 1;

    const TYPE_DOUBLE = 2;

    public static $tourneyTypeSelect
        = [
            self::TYPE_SINGLE => 'SINGLE',
            self::TYPE_DOUBLE => 'DOUBLE',
        ];
    public static $tourneyType
        = [
            self::TYPE_SINGLE => 'Single-elimination tournament',
            self::TYPE_DOUBLE => 'Double-elimination tournament',
        ];

    const YES = 1;

    const NO = 2;

    public static $newStatus
        = [
            5 => 'STARTED', 6 => 'FINISHED',
        ];
    public static $status
        = [
            1 => 'ANNOUNCE', 2 => 'REGISTRATION', 3 => 'CHECK-IN',
            4 => 'GENERATION', 5 => 'STARTED', 6 => 'FINISHED',
        ];

    public static $status2
        = [
            5 => 'STARTED', 6 => 'FINISHED',
        ];
    public static $map_types
        = [
            1 => 'NONE', 2 => 'FIRSTBYREMOVING', 3 => 'FIRSTBYROUND',
        ];
    public static $matchType
        = [
            1 => 'SINGLE', 2 => 'DOUBLE',
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
            'type',
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
