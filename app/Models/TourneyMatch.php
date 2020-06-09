<?php

namespace App\Models;

use App\Traits\ModelRelations\TourneyMatchRelation;
use DB;
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
            1 => 'winners', 2 => 'losers', 3 => 'finals',
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
    public static function roundsCanCreate(int $allPlayers): float
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
    public static function roundExist(int $tourneyId, int $roundNumber): bool
    {
        return self::query()->where('tourney_id', $tourneyId)->where('round_number', $roundNumber)->exists();
    }

    /**
     * @param  int  $tourneyId
     * @param  int  $roundNumber
     *
     * @return bool
     */
    public static function roundPreviousExist(int $tourneyId, int $roundNumber): bool
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
        return self::query()
            ->whereNotNull('player1_id')
            ->where('tourney_id', $tourneyId)
            ->where('round_number', $round - 1)
            ->where('played', true)
            ->where('branch', $branch)
            ->where('player1_score', '>', DB::raw('player2_score'))
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
        return self::query()
            ->whereNotNull('player2_id')
            ->where('tourney_id', $tourneyId)
            ->where('round_number', $round - 1)
            ->where('played', true)
            ->where('branch', $branch)
            ->where('player2_score', '>', DB::raw('player2_score'))
            ->get();
    }

    /**
     * @param  int  $tourneyId
     * @param  int  $round
     *
     * @return int
     */
    public static function getMaxMatchNumber(int $tourneyId, int $round): int
    {
        return self::query()->where('tourney_id', $tourneyId)
            ->where('round_number', $round - 1)->max('match_number');
    }

    /**
     * @param  int  $tourneyId
     *
     * @return int
     */
    public static function getMaxRoundNumber(int $tourneyId): int
    {
        $roundNumber = self::query()->where('tourney_id', $tourneyId)->max('round_number');

        if ($roundNumber > 1) {
            return $roundNumber;
        } else {
            return 1;
        }
    }

    /**
     * @param  int  $tourneyId
     * @param  int  $round
     *
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Query\Builder[]|\Illuminate\Support\Collection
     */
    public static function getWinnersAmongWinners(int $tourneyId, int $round)
    {
        $player1 = self::with('checkPlayers1:id,tourney_id,description,defeat')
            ->whereNotNull('player1_id')
            ->whereHas('checkPlayers1', function ($q) {
                $q->where('defeat', 0);
            })->where('tourney_id', $tourneyId)
            ->where('round_number', $round - 1)
            ->where('branch', array_search('winners', TourneyMatch::$branches))
            ->where('played', true)
            ->where('player1_score', 2)
            ->where('player2_score', 0)
            ->get([
                'id', 'tourney_id', 'round_number', 'branch', 'played', 'player1_score', 'player2_score', 'player1_id',
            ]);

        $player2 = self::with('checkPlayers2:id,tourney_id,description,defeat')
            ->whereNotNull('player2_id')
            ->whereHas('checkPlayers2', function ($q) {
                $q->where('defeat', 0);
            })->where('tourney_id', $tourneyId)
            ->where('round_number', $round - 1)
            ->where('branch', array_search('winners', TourneyMatch::$branches))
            ->where('played', true)
            ->where('player1_score', 0)
            ->where('player2_score', 2)
            ->get([
                'id', 'tourney_id', 'round_number', 'branch', 'played', 'player1_score', 'player2_score', 'player2_id',
            ]);

        return $player1->merge($player2);
    }

    /**
     * @param  int  $tourneyId
     * @param  int  $round
     *
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Query\Builder[]|\Illuminate\Support\Collection
     */
    public static function getLosersAmongWinners(int $tourneyId, int $round)
    {
        $player1 = self::with('checkPlayers1:id,tourney_id,description,defeat')
            ->whereNotNull('player1_id')
            ->whereHas('checkPlayers1', function ($q) {
                $q->where('defeat', 1);
            })->where('tourney_id', $tourneyId)
            ->where('round_number', $round - 1)
            ->where('branch', array_search('winners', TourneyMatch::$branches))
            ->where('played', true)
            ->where('player1_score', 0)
            ->where('player2_score', 2)
            ->get([
                'id', 'tourney_id', 'round_number', 'branch', 'played', 'player1_score', 'player2_score', 'player1_id',
            ]);
        $player2 = self::with('checkPlayers2:id,tourney_id,description,defeat')
            ->whereNotNull('player2_id')
            ->whereHas('checkPlayers2', function ($q) {
                $q->where('defeat', 1);
            })->where('tourney_id', $tourneyId)
            ->where('round_number', $round - 1)
            ->where('branch', array_search('winners', TourneyMatch::$branches))
            ->where('played', true)
            ->where('player1_score', 2)
            ->where('player2_score', 0)
            ->get([
                'id', 'tourney_id', 'round_number', 'branch', 'played', 'player1_score', 'player2_score', 'player2_id',
            ]);

        return $player1->merge($player2);
    }

    /**
     * @param  int  $tourneyId
     * @param  int  $round
     *
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Query\Builder[]|\Illuminate\Support\Collection
     */
    public static function getWinnersAmongLosers(int $tourneyId, int $round)
    {
        $player1 = self::with('checkPlayers1:id,tourney_id,description,defeat')
            ->whereNotNull('player1_id')
            ->whereHas('checkPlayers1', function ($q) {
                $q->where('defeat', 1);
            })->where('tourney_id', $tourneyId)
            ->where('round_number', $round - 1)
            ->where('branch', array_search('losers', TourneyMatch::$branches))
            ->where('played', true)
            ->where('player1_score', 2)
            ->where('player2_score', 0)
            ->get([
                'id', 'tourney_id', 'round_number', 'branch', 'played', 'player1_score', 'player2_score', 'player1_id',
            ]);

        $player2 = self::with('checkPlayers2:id,tourney_id,description,defeat')
            ->whereNotNull('player2_id')
            ->whereHas('checkPlayers2', function ($q) {
                $q->where('defeat', 1);
            })->where('tourney_id', $tourneyId)
            ->where('round_number', $round - 1)
            ->where('branch', array_search('losers', TourneyMatch::$branches))
            ->where('played', true)
            ->where('player1_score', 0)
            ->where('player2_score', 2)
            ->get([
                'id', 'tourney_id', 'round_number', 'branch', 'played', 'player1_score', 'player2_score', 'player2_id',
            ]);

        return $player1->merge($player2);
    }


    /**
     * @param  int  $tourneyId
     * @param  int  $round
     *
     * @return int
     */
    public static function getWinnersAmongWinnersCount(int $tourneyId, int $round): int
    {
        $player1 = self::with('checkPlayers1:id,tourney_id,description,defeat')
            ->whereNotNull('player1_id')
            ->whereHas('checkPlayers1', function ($q) {
                $q->where('defeat', 0);
            })->where('tourney_id', $tourneyId)
            ->where('round_number', $round - 1)
            ->where('branch', array_search('winners', TourneyMatch::$branches))
            ->where('played', true)
            ->where('player1_score', 2)
            ->where('player2_score', 0)
            ->count();
        $player2 = self::with('checkPlayers2:id,tourney_id,description,defeat')
            ->whereNotNull('player2_id')
            ->whereHas('checkPlayers2', function ($q) {
                $q->where('defeat', 0);
            })->where('tourney_id', $tourneyId)
            ->where('round_number', $round - 1)
            ->where('branch', array_search('winners', TourneyMatch::$branches))
            ->where('played', true)
            ->where('player1_score', 0)
            ->where('player2_score', 2)
            ->count();

        return $player1 + $player2;
    }

    /**
     * @param  int  $tourneyId
     * @param  int  $round
     *
     * @return int
     */
    public static function getLosersAmongWinnersCount(int $tourneyId, int $round): int
    {
        $player1 = self::with('checkPlayers1:id,tourney_id,description,defeat')
            ->whereNotNull('player1_id')
            ->whereHas('checkPlayers1', function ($q) {
                $q->where('defeat', 1);
            })->where('tourney_id', $tourneyId)
            ->where('round_number', $round - 1)
            ->where('branch', array_search('winners', TourneyMatch::$branches))
            ->where('played', true)
            ->where('player1_score', 0)
            ->where('player2_score', 2)
            ->count();
        $player2 = self::with('checkPlayers2:id,tourney_id,description,defeat')
            ->whereNotNull('player2_id')
            ->whereHas('checkPlayers2', function ($q) {
                $q->where('defeat', 1);
            })->where('tourney_id', $tourneyId)
            ->where('round_number', $round - 1)
            ->where('branch', array_search('winners', TourneyMatch::$branches))
            ->where('played', true)
            ->where('player1_score', 2)
            ->where('player2_score', 0)
            ->count();

        return $player1 + $player2;
    }

    /**
     * @param  int  $tourneyId
     * @param  int  $round
     *
     * @return int
     */
    public static function getWinnersAmongLosersCount(int $tourneyId, int $round): int
    {
        $player1 = self::with('checkPlayers1:id,tourney_id,description,defeat')
            ->whereNotNull('player1_id')
            ->whereHas('checkPlayers1', function ($q) {
                $q->where('defeat', 1);
            })->where('tourney_id', $tourneyId)
            ->where('round_number', $round - 1)
            ->where('branch', array_search('losers', TourneyMatch::$branches))
            ->where('played', true)
            ->where('player1_score', 2)
            ->where('player2_score', 0)
            ->count();
        $player2 = self::with('checkPlayers2:id,tourney_id,description,defeat')
            ->whereNotNull('player2_id')
            ->whereHas('checkPlayers2', function ($q) {
                $q->where('defeat', 1);
            })->where('tourney_id', $tourneyId)
            ->where('round_number', $round - 1)
            ->where('branch', array_search('losers', TourneyMatch::$branches))
            ->where('played', true)
            ->where('player1_score', 0)
            ->where('player2_score', 2)
            ->count();

        return $player1 + $player2;
    }


    /**
     * @param  int  $tourneyId
     * @param  int  $round
     *
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|\Illuminate\Database\Query\Builder|object|null
     */
    public static function getFinalsRound(int $tourneyId, int $round)
    {
        return self::with('checkPlayers1:id,tourney_id,description,defeat',
            'checkPlayers2:id,tourney_id,description,defeat')
            ->whereNotNull('player1_id')
            ->whereNotNull('player2_id')
            ->where('tourney_id', $tourneyId)
            ->where('round_number', $round - 1)
            ->where('branch', array_search('finals', TourneyMatch::$branches))
            ->where('played', true)
            ->first();
    }

    /**
     * @param  int  $tourneyId
     * @param  int  $round
     *
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Query\Builder[]|\Illuminate\Support\Collection
     */
    public static function getLosersAmongFinals(int $tourneyId, int $round)
    {
        $player1 = self::with('checkPlayers1:id,tourney_id,description,defeat')
            ->whereNotNull('player1_id')
            ->whereHas('checkPlayers1', function ($q) {
                $q->where('defeat', '<', 2);
            })
            ->where('tourney_id', $tourneyId)
            ->where('round_number', $round - 1)
            ->where('branch', array_search('finals', TourneyMatch::$branches))
            ->where('played', true)
            ->where('player1_score', '<', DB::raw('player2_score'))
            ->value('player1_score');

        $player2 = self::with('checkPlayers2:id,tourney_id,description,defeat')
            ->whereNotNull('player2_id')
            ->whereHas('checkPlayers2', function ($q) {
                $q->where('defeat', '<', 2);
            })
            ->where('tourney_id', $tourneyId)
            ->where('round_number', $round - 1)
            ->where('branch', array_search('finals', TourneyMatch::$branches))
            ->where('played', true)
            ->where('player2_score', '<', DB::raw('player1_score'))
            ->value('player2_id');

        return ! empty($player1) ? $player1 : $player2;
    }

}
