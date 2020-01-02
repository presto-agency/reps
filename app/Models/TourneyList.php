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
    public static $status
        = [
            0 => 'ANNOUNCE', 1 => 'REGISTRATION', 2 => 'CHECK-IN',
            3 => 'GENERATION', 4 => 'STARTED', 5 => 'FINISHED',
        ];

    public static $map_types
        = [
            0 => 'NONE', 1 => 'FIRSTBYREMOVING', 2 => 'FIRSTBYROUND',
        ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable
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
            'checkin_time',
            'start_time',
        ];

    protected $guarded = ['importance', 'user_id'];

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
            'status'          => 'integer',
            'map_select_type' => 'integer',
            'user_id'         => 'integer',
            'importance'      => 'integer',
            'visible'         => 'boolean',
            'ranking'         => 'boolean',
            'start_time'      => 'datetime',
            'checkin_time'    => 'datetime',
        ];


}
