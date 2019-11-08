<?php

namespace App\Models;

use App\Traits\ModelRelations\TourneyMatchRelation;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class TourneyMatch extends Model
{
    use Notifiable, TourneyMatchRelation;
    /**
     * Using table name
     *
     * @var string
     */
    protected $table = 'tourney_matches';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'tourney_id',
        'match_id',
        'round',
        'round_id',
        'player1_id',
        'player2_id',
        'player1_score',
        'player2_score',
        'win_score',
        'winner_action',
        'winner_value',
        'looser_action',
        'looser_value',
        'played',
        'rep1',
        'rep2',
        'rep3',
        'rep4',
        'rep5',
        'rep6',
        'rep7'
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = true;

    /**
     * @param $tourney_id
     * @param $round_id
     * @return string
     */
    public static function getTourneyRoundMap($tourney_id, $round_id)
    {

        $tourney = TourneyList::where('id', $tourney_id)->value('maps');
        $mapArray = explode(",", $tourney);
        $mapsCount = count($mapArray);
        $mapIndex = $round_id % $mapsCount;
        $mapName = $mapArray[$mapIndex];
        $tourneyMap = ReplayMap::where('name', $mapName)->first(['url', 'name']);
        if (!empty($tourneyMap)) {
            return "<a href=" . asset($tourneyMap->url) . " title='$tourneyMap->name'>$tourneyMap->name</a>";
        } else {
            return null;
        }
    }
}