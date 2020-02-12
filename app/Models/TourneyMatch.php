<?php

namespace App\Models;

use App\Traits\ModelRelations\TourneyMatchRelation;
use Illuminate\Database\Eloquent\Model;

class TourneyMatch extends Model
{

    use  TourneyMatchRelation;

    public static $action
        = [
            1 => 'NONE', 2 => 'GOTO_P1', 3 => 'GOTO_P2', 4 => 'TOP',
        ];

    public static $branches
        = [
            1 => 'winners', 2 => 'losers',
        ];

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
            'branch',
            'played',
            'round',
            'rep1',
            'rep2',
            'rep3',
            'rep4',
            'rep5',
            'rep6',
            'rep7',
            'reps',
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
            'match_type'    => 'int',
        ];


    /**
     * @param  int  $allPlayers
     *
     * @return false|float
     */
    public static function roundsCanCreate(int $allPlayers)
    {
        return ceil(log($allPlayers, 2.0));
    }

    /**
     * @param  int  $tourneyId
     *
     * @return int
     */
    public static function roundsNowCreate(int $tourneyId)
    {
        return self::query()->where('tourney_id', $tourneyId)->distinct('round_number')->count();
    }

    /**
     * @param  int  $tourneyId
     * @param  int  $roundNumber
     *
     * @return bool
     */
    public static function roundExist(int $tourneyId, int $roundNumber)
    {
        return self::query()->where('tourney_id', $tourneyId)->where('round_number', $roundNumber)->exists();
    }

    /**
     * @param  int  $tourneyId
     * @param  int  $roundNumber
     *
     * @return bool
     */
    public static function roundPreviousExist(int $tourneyId, int $roundNumber)
    {
        if ($roundNumber > 1) {
            return self::query()->where('tourney_id', $tourneyId)->where('round_number', '<', $roundNumber)->exists();
        } else {
            return false;
        }
    }

    /**
     * @param  int  $tourneyId
     * @param  int  $round
     * @param  int  $branch
     *
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Query\Builder[]|\Illuminate\Support\Collection
     */
    public static function winnersPlayer1(int $tourneyId, int $round, int $branch)
    {
        return TourneyMatch::query()
            ->whereNotNull('player1_id')
            ->where('tourney_id', $tourneyId)
            ->where('round_number', $round - 1)
            ->where('played', true)
            ->where('branch', $branch)
            ->where('player1_score', '>', \DB::raw('player2_score'))
            ->get();
    }

    /**
     * @param  int  $tourneyId
     * @param  int  $round
     * @param  int  $branch
     *
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Query\Builder[]|\Illuminate\Support\Collection
     */
    public static function winnersPlayer2(int $tourneyId, int $round, int $branch)
    {
        return TourneyMatch::query()
            ->whereNotNull('player2_id')
            ->where('tourney_id', $tourneyId)
            ->where('round_number', $round - 1)
            ->where('played', true)
            ->where('branch', $branch)
            ->where('player2_score', '>', \DB::raw('player2_score'))
            ->get();
    }

    /**
     * @param  int  $tourneyId
     * @param  int  $round
     *
     * @return mixed
     */
    public static function getMaxMatchNumber(int $tourneyId, int $round)
    {
        return self::query()->where('tourney_id', $tourneyId)
            ->where('round_number', $round - 1)->max('match_number');
    }

    /**
     * @param  int  $tourneyId
     *
     * @return int|mixed
     */
    public static function getMaxRoundNumber(int $tourneyId)
    {
        $roundNumber = self::query()->where('tourney_id', $tourneyId)->max('round_number');

        if ($roundNumber > 1) {
            return $roundNumber;
        } else {
            return 1;
        }
    }

}
