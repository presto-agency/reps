<?php


namespace App\Services\MatchGenerator;


use App\Models\TourneyList;
use Carbon\Carbon;

class TourneyDouble
{

    /**
     * @param  int  $tourneyId
     * @param  int  $round
     * @param  int  $matchNumber
     * @param $players
     * @param  int  $playerCount
     * @param  int  $branch
     * @param  string  $for
     *
     * @return array
     */
    public static function roundTwoMatches(
        int $tourneyId,
        int $round,
        int $matchNumber,
        $players,
        int $playerCount,
        int $branch,
        string $for = ''
    ): array {
        $matches   = [];
        $playerArr = [];

        foreach ($players as $item) {
            if (isset($item->player1_id)) {
                $playerArr[] = [
                    'id' => $item->player1_id,
                ];
            }
            if (isset($item->player2_id)) {
                $playerArr[] = [
                    'id' => $item->player2_id,
                ];
            }
        }

        if (($playerCount & 1)) {
            $playerArr[] = ['id' => null];
        }
        if ($for != 'Super Final Round' && $for != 'Super Final Round 2') {
            $setRound = 'Round '.$round.' '.$for.' (of '.TourneyList::allPlayers($playerCount).')';
        } else {
            $setRound = $for.' Round '.$round.' (of '.TourneyList::allPlayers($playerCount).')';
        }

        for ($i = 0; $i < $playerCount / 2; $i++) {
            $matchNumber++;
            $matches[] = [
                'tourney_id'   => $tourneyId,
                'player1_id'   => $playerArr[$i]['id'],
                'player2_id'   => $playerArr[$playerCount / 2 + $i + TourneyList::void($playerCount)]['id'],
                'match_number' => $matchNumber,
                'round_number' => (int) $round,
                'branch'       => $branch,
                'played'       => false,
                'round'        => $setRound,
                'created_at'   => Carbon::now(),
            ];
        }

        return $matches;
    }

}
