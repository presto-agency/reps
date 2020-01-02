<?php

namespace App\Models;

use App\Traits\ModelRelations\TourneyMatchRelation;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class TourneyMatch extends Model
{

    use Notifiable, TourneyMatchRelation;

    public static $action
        = [
            0 => "TOP", 1 => "GOTO_P1", 2 => "GOTO_P2", 3 => "NONE",
        ];

    protected $fillable
        = [
            'player1_score',
            'player2_score',
            'winner_score',
            'winner_action',
            'winner_value',
            'looser_action',
            'looser_value',
            'match_number',
            'round_number',
            'played',
            'round',
            'rep1',
            'rep2',
            'rep3',
            'rep4',
            'rep5',
            'rep6',
            'rep7',
        ];
    protected $guarded
        = [
            'tourney_id',
            'player1_id',
            'player2_id',
        ];

    protected $casts
        = [
            'player1_score' => 'integer',
            'player2_score' => 'integer',
            'winner_score'  => 'integer',
            'winner_action' => 'integer',
            'winner_value'  => 'integer',
            'looser_action' => 'integer',
            'looser_value'  => 'integer',
            'match_number'  => 'integer',
            'round_number'  => 'integer',
            'played'        => 'boolean',
            'round'         => 'string',
            'rep1'          => 'string',
            'rep2'          => 'string',
            'rep3'          => 'string',
            'rep4'          => 'string',
            'rep5'          => 'string',
            'rep6'          => 'string',
            'rep7'          => 'string',
            'tourney_id'    => 'integer',
            'player1_id'    => 'integer',
            'player2_id'    => 'integer',
        ];

}
