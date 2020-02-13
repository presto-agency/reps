<?php


namespace App\Services\MatchGenerator;


use App\Models\TourneyList;
use App\Models\TourneyMatch;
use Carbon\Carbon;

class TourneySingle
{

    /**
     * @param  int  $tourneyId
     * @param  int  $round
     * @param $players
     * @param  int  $playerCount
     *
     * @return array
     */
    public static function roundOneMatches(int $tourneyId, int $round, $players, int $playerCount): array
    {
        $matches = [];

        if (($playerCount & 1)) {
            $players[] = ['id' => null];
        }

        for ($i = 0; $i < $playerCount / 2; $i++) {
            $matches[] = [
                'tourney_id'   => $tourneyId,
                'player1_id'   => $players[$i]['id'],
                'player2_id'   => $players[$playerCount / 2 + $i + TourneyList::void($playerCount)]['id'],
                'match_number' => $i + 1,
                'round_number' => $round,
                'played'       => false,
                'round'        => 'Round '.$round.' (of '.TourneyList::allPlayers($playerCount).')',
                'created_at'   => Carbon::now(),
            ];
        }

        return $matches;
    }

    /**
     * @param  int  $tourneyId
     * @param  int  $matchNumber
     * @param  int  $round
     * @param  $players
     * @param  int  $playerCountAll
     *
     * @return array
     */
    public static function roundNextMatches(int $tourneyId, int $matchNumber, int $round, $players, int $playerCountAll): array
    {
        $playerArr = [];
        $matches   = [];
        foreach ($players as $item) {
            if (isset($item['player1_id'])) {
                $playerArr[] = [
                    'id' => $item->player1_id,
                ];
            }
            if (isset($item['player2_id'])) {
                $playerArr[] = [
                    'id' => $item->player2_id,
                ];
            }
        }

        $playerCount = $players->count();
        if (($playerCount & 1)) {
            $playerArr[] = ['id' => null];
        }

        $setRound = 'Round '.$round.' (of '.TourneyList::allPlayers($playerCount).')';

        if (ceil(log($playerCountAll, 2.0)) == (double) $round) {
            $setRound = 'Super Final Round';
        }


        for ($i = 0; $i < $playerCount / 2; $i++) {
            $matchNumber++;
            $matches[] = [
                'tourney_id'   => $tourneyId,
                'player1_id'   => $playerArr[$i]['id'],
                'player2_id'   => $playerArr[$playerCount / 2 + $i + TourneyList::void($playerCount)]['id'],
                'match_number' => $matchNumber,
                'round_number' => $round,
                'played'       => false,
                'round'        => $setRound,
                'created_at'   => Carbon::now(),
            ];
        }

        return $matches;
    }


    /**
     * @param  int  $tourneyId
     * @param  int  $round
     *
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Query\Builder[]|\Illuminate\Support\Collection
     */
    public static function getPlayers(int $tourneyId, int $round)
    {
        $players1 = TourneyMatch::winnersPlayer1($tourneyId, $round, array_search('winners', TourneyMatch::$branches));
        $players2 = TourneyMatch::winnersPlayer2($tourneyId, $round, array_search('winners', TourneyMatch::$branches));

        return $players1->merge($players2);
    }

    /**
     * @param $data
     * @param  int  $round
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public static function save($data, int $round)
    {
        try {
            \DB::table('tourney_matches')->insert($data);

            return back()->with(['single-match-success' => "Матчи для раунда $round успешно созданы"]);
        } catch (\Exception $e) {
            \Log::error($e->getMessage());

            return back()->withErrors(['single-match' => "Ошибка при создании матчей для раунда $round"]);
        }
    }

}
