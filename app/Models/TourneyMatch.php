<?php

namespace App\Models;

use App\Traits\ModelRelations\TourneyMatchRelation;
use Illuminate\Database\Eloquent\Model;

class TourneyMatch extends Model
{

    use  TourneyMatchRelation;

    const TYPE_SINGLE = '1';

    const TYPE_DOUBLE = '2';

    public static $action
        = [
            1 => 'NONE', 2 => 'GOTO_P1', 3 => 'GOTO_P2', 4 => 'TOP',
        ];

    //    protected $fillable
    //        = [
    //
    //        ];
    protected $guarded
        = [
            'tourney_id',
            'player1_id',
            'player2_id',
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

    protected $casts
        = [
            'player1_score' => 'int',
            'player2_score' => 'int',
            'winner_score'  => 'int',
            'winner_action' => 'int',
            'winner_value'  => 'int',
            'looser_action' => 'int',
            'looser_value'  => 'int',
            'match_number'  => 'int',
            'round_number'  => 'int',
            'played'        => 'int',
            'round'         => 'string',
            'rep1'          => 'string',
            'rep2'          => 'string',
            'rep3'          => 'string',
            'rep4'          => 'string',
            'rep5'          => 'string',
            'rep6'          => 'string',
            'rep7'          => 'string',
            'tourney_id'    => 'int',
            'player1_id'    => 'int',
            'player2_id'    => 'int',
        ];

}
