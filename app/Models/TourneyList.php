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
    const TYPE_SINGLE = 1;

    const TYPE_DOUBLE = 2;

    public static $tourneyTypeSelect
        = [
            self::TYPE_SINGLE => 'SINGLE',
            self::TYPE_DOUBLE => 'DOUBLE',
        ];
    public static $tourneyType
        = [
            self::TYPE_SINGLE => 'Single-elimination tournament',
            self::TYPE_DOUBLE => 'Double-elimination tournament',
        ];

    const YES = 1;

    const NO = 2;

    public static $newStatus
        = [
            5 => 'STARTED', 6 => 'FINISHED',
        ];
    public static $status
        = [
            1 => 'ANNOUNCE', 2 => 'REGISTRATION', 3 => 'CHECK-IN',
            4 => 'GENERATION', 5 => 'STARTED', 6 => 'FINISHED',
        ];

    public static $status2
        = [
            5 => 'STARTED', 6 => 'FINISHED',
        ];
    public static $map_types
        = [
            1 => 'NONE', 2 => 'FIRSTBYREMOVING', 3 => 'FIRSTBYROUND',
        ];
    public static $matchType
        = [
            1 => 'SINGLE', 2 => 'DOUBLE',
        ];

    public static $yesOrNo
        = [
            self::NO => 'No', self::YES => 'Yes',
        ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded
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
            'type',
            'visible',
            'ranking',
            'reg_time',
            'checkin_time',
            'start_time',
            'importance',
            'user_id',
        ];

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
            'status'          => 'int',
            'map_select_type' => 'int',
            'user_id'         => 'int',
            'importance'      => 'int',
            'visible'         => 'int',
            'ranking'         => 'int',

        ];

    /**
     * @param $tourney
     *
     * @return array
     */
    public static function getGeneratorData($tourney): array
    {
        $rounds     = [];
        $allPlayers = self::allPlayers($tourney->check_players_count);


        if ($allPlayers > 0) {
            if ($tourney->type == self::TYPE_SINGLE) {
                $rounds = self::singleRoundsData($allPlayers, $tourney);
            }
            if ($tourney->type == self::TYPE_DOUBLE) {
                $rounds = self::doubleRoundsData($allPlayers, $tourney);
            }
        }

        return $rounds;
    }

    /**
     * @param  int  $allPlayers
     * @param $tourney
     *
     * @return array
     */
    public static function singleRoundsData(int $allPlayers, $tourney): array
    {
        $data['allMatches']       = $tourney->matches_count;
        $data['allPlayers']       = $allPlayers;
        $data['roundsCanCreate']  = TourneyMatch::roundsCanCreate($allPlayers);
        $data['roundsNowCreate']  = TourneyMatch::roundsNowCreate($tourney->id);
        $data['roundsLeftCreate'] = $data['roundsCanCreate'] - $data['roundsNowCreate'];
        $data['rounds']           = self::singleRounds($data['roundsCanCreate'], $tourney->id);

        return $data;
    }

    /**
     * @param  int  $roundsCanCreate
     * @param  int  $tourneyId
     *
     * @return array
     */
    public static function singleRounds(int $roundsCanCreate, int $tourneyId): array
    {
        $data = [];
        for ($i = 1; $i <= $roundsCanCreate; $i++) {
            $data[] = [
                'roundNumber'        => $i,
                'roundExist'         => TourneyMatch::roundExist($tourneyId, $i),
                'roundPreviousExist' => TourneyMatch::roundPreviousExist($tourneyId, $i),
            ];
        }

        return $data;
    }

    /**
     * @param  int  $allPlayers
     * @param $tourney
     *
     * @return array
     */
    public static function doubleRoundsData(int $allPlayers, $tourney): array
    {
        $roundNumber = TourneyMatch::getMaxRoundNumber($tourney->id);

        $data['allMatches']      = $tourney->matches_count;
        $data['allPlayers']      = $allPlayers;
        $data['roundsNowCreate'] = TourneyMatch::roundsNowCreate($tourney->id);
        $data['rounds'][]        = [
            'roundNumber'     => $roundNumber,
            'roundNumberNext' => $roundNumber + 1,
            'roundExist'      => TourneyMatch::roundExist($tourney->id, $roundNumber),
            'roundExistNext'  => TourneyMatch::roundExist($tourney->id, $roundNumber + 1),
        ];

        return $data;
    }


    /**
     * @param $playersCount
     *
     * @return int
     */
    public static function allPlayers($playersCount)
    {
        return $playersCount + self::void($playersCount);
    }

    /**
     * @param $playersCount
     *
     * @return int
     */
    public static function void($playersCount)
    {
        return $playersCount & 1 ? 1 : 0;
    }

    /**
     * @param  int  $id
     *
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model
     */
    public static function getStartedTourneyWithPlayers(int $id)
    {
        return self::with('checkPlayers')->withCount('checkPlayers')
            ->where('status', array_search('STARTED', self::$status))
            ->findOrFail($id);
    }

}
