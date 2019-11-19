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
     * @return string|null
     */
    public static function getTourneyMap($mapId)
    {
        $tourneyMap = ReplayMap::where('id', $mapId)->first();

        $data = null;
        if (!empty($tourneyMap->name)){
            $data['title'] = "<span class='title_text'>" . $tourneyMap->name . "</span>";

        }
        if (!empty($tourneyMap->url)){
            $data['url'] = "<div class='map'>" . "<img src=".asset($tourneyMap->url)." alt='$tourneyMap->name' title='$tourneyMap->name'>" . "</div>";
        }else{
            $data['url'] = "<div class='map'>" . "<img src=".asset($tourneyMap->defaultMap())." alt='$tourneyMap->name' title='$tourneyMap->name'>" . "</div>";

        }

        return $data;
    }


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
        $mapId = $mapArray[$mapIndex];
        $tourneyMap = ReplayMap::where('id', $mapId)->first([
            'url',
            'name'
        ]);
        if (!empty($tourneyMap)) {
            return "<a href=" . asset($tourneyMap->url) . " title='$tourneyMap->name'>$tourneyMap->name</a>";
        } else {
            return "<a href=" . asset($tourneyMap->defaultMap()) . " title='$tourneyMap->name'>$tourneyMap->name</a>";
        }
    }
}
