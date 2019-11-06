<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TourneyList extends Model
{
    /**
     * var array
     */
    public static $status = array(
        0 => 'ANNOUNCE', 1 => 'REGISTRATION', 2 => 'CHECK-IN', 3 => 'GENERATION', 4 => 'STARTED', 5 => 'FINISHED'
    );

    public static $map_types = [
        0 => 'NONE', 1 => 'FIRSTBYREMOVING', 2 => 'FIRSTBYROUND'
    ];
    /**
     * Using table name
     *
     * @var string
     */
    protected $table = 'tourney_lists';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'tourney_id',
        'admin_id',
        'name',
        'place',
        'prize_pool',
        'status',
        'visible',
        'maps',
        'rules_link',
        'vod_link',
        'logo_link',
        'map_selecttype',
        'importance',
        'is_ranking',
        'password',
        'checkin_time'
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = true;


    /**
     * Relations.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function players()
    {
        return $this->hasMany('App\Models\TourneyPlayer', 'tourney_id');
    }

    public function admin_user()
    {
        return $this->belongsTo('App\User', 'admin_id');
    }

    public function checkin_players()
    {
        return $this->hasMany('App\Models\TourneyPlayer', 'tourney_id')->where('check_in', 1);
    }

    public function win_player()
    {
        return $this->hasMany('App\Models\TourneyPlayer', 'tourney_id')->where('place_result', 1);
    }
}
