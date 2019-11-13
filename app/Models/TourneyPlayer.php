<?php

namespace App\Models;

use App\Traits\ModelRelations\TourneyPlayerRelation;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class TourneyPlayer extends Model
{
    use Notifiable, TourneyPlayerRelation;
    /**
     * Using table name
     *
     * @var string
     */
    protected $table='tourney_players';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'tourney_id',
        'user_id',
        'check_in',
        'description',
        'place_result'
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = true;

}
