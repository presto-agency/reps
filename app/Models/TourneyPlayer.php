<?php

namespace App\Models;

use App\Traits\ModelRelations\TourneyPlayerRelation;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class TourneyPlayer extends Model
{

    use Notifiable, TourneyPlayerRelation;

    protected $fillable
        = [
            'check',
            'description',
            'place_result',
        ];

    protected $guarded
        = [
            'tourney_id',
            'user_id',
        ];
    protected $casts
        = [
            'check'        => 'boolean',
            'description'  => 'string',
            'place_result' => 'integer',
            'tourney_id'   => 'integer',
            'user_id'      => 'integer',
        ];

}
