<?php

namespace App\Http\Controllers\admin\Tournament;

use AdminSection;
use App\Http\Controllers\Controller;
use App\Models\TourneyList;
use App\Models\TourneyMatch;
use Carbon\Carbon;
use Illuminate\Http\Request;


class MatchGeneratorController extends Controller
{

    public function show(int $id)
    {
        $tourney     = TourneyList::query()->withCount('matches', 'checkPlayers')->find($id);
        $type        = TourneyMatch::TYPE_SINGLE;
        $playerCount = $tourney->check_players_count;
        $void        = 0;

        if (($playerCount & 1)) {
            $void = 1;
        }
        $ofRound = $playerCount + $void;
        /**
         * Check Rounds
         */
        $rounds   = [];
        $existAll = true;
        if ( ! empty($ofRound)) {
            $rounds = ['canCreate' => ceil(log($ofRound, 2.0))];

            for ($i = 1; $i <= $rounds['canCreate']; $i++) {
                $rounds['rounds'][] = [
                    'number'        => $i,
                    'previousExist' => TourneyMatch::query()->where('tourney_id', $id)->where('round_number', '<', $i)->exists(),
                    'exist'         => TourneyMatch::query()->where('tourney_id', $id)->where('round_number', $i)->exists(),
                ];
            }

            foreach ($rounds['rounds'] as $item) {
                if ($item['exist'] === false) {
                    $existAll = false;
                    break;
                }
            }
        }

        $content = view('admin.tourneyMatchGenerator.show', compact('rounds', 'type', 'tourney', 'existAll'));

        return AdminSection::view($content, 'Match Generator');
    }

    public function matchGenerator(Request $request)
    {

        if ($request->get('type') == TourneyMatch::TYPE_SINGLE) {
            return $this->single($request->get('id'), $request->get('round'));
        }

        return back();
    }


    /**
     * Single-elimination tournament
     *
     * @param  int  $id
     * @param  null  $round
     *
     * @return null
     */
    private function single(int $id, $round = null)
    {
        if ($round == 1) {
            return $this->single_round_1($id, $round);
        } else {
            return $this->single_round_other($id, $round);
        }
    }

    private function single_round_1(int $id, $round)
    {
        $tourney     = TourneyList::with('checkPlayers')
            ->withCount('checkPlayers')
            ->find($id);
        $playerCount = $tourney->check_players_count;

        if ($playerCount == 0) {
            return $this->redirectToError();
        }
        $matches = [];
        $players = $tourney->checkPlayers->shuffle();

        $void = 0;

        if (($playerCount & 1)) {
            $players[] = ['id' => null];
            $void      = 1;
        }

        $ofRound  = $playerCount + $void;
        $setRound = "Round $round (of $ofRound)";

        for ($i = 0; $i < $playerCount / 2; $i++) {
            $matches[] = [
                'tourney_id'   => $tourney['id'],
                'player1_id'   => $players[$i]['id'],
                'player2_id'   => $players[$playerCount / 2 + $i + $void]['id'],
                'match_number' => $i + 1,
                'round_number' => $round,
                'played'       => false,
                'round'        => $setRound,
                'match_type'   => array_search('SINGLE', TourneyList::$matchType),
                'created_at'   => Carbon::now(),
            ];
        }

        try {
            $this->store($matches);

            return $this->redirectToSuccess($round);
        } catch (\Exception $e) {
            \Log::error($e->getMessage());

            return back()->withErrors(['single-match' => $e->errorInfo[2]]);
        }
    }

    private function single_round_other(int $id, $round)
    {

        /**
         * Get all winner Player1
         */
        $player1 = TourneyMatch::query()
            ->whereNotNull('player1_id')
            ->where('tourney_id', $id)
            ->where('round_number', $round - 1)
            ->where('played', true)
            ->where('player1_score', '>', \DB::raw('player2_score'))
            ->get(['id', 'tourney_id', 'player1_id', 'player1_score', 'player2_score', 'round_number', 'played']);
        /**
         * Get all winner Player2
         */
        $player2 = TourneyMatch::query()
            ->whereNotNull('player2_id')
            ->where('tourney_id', $id)
            ->where('round_number', $round - 1)
            ->where('played', true)
            ->where('player2_score', '>', \DB::raw('player1_score'))
            ->get(['id', 'tourney_id', 'player2_id', 'player1_score', 'player2_score', 'round_number', 'played']);

        $players = $player1->merge($player2);

        if ($players->isEmpty()) {
            return $this->redirectToError();
        }
        $matchNumber          = TourneyMatch::query()
            ->where('tourney_id', $id)
            ->where('round_number', $round - 1)->max('match_number');
        $checkPlayersCountMax = TourneyList::query()->select(['id'])->withCount('checkPlayers')
            ->where('id', $id)->value('check_players_count');

        $playerCount = $players->count();
        $players     = $players->shuffle();

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

        $void = 0;

        if (($playerCount & 1)) {
            $playerArr[] = ['id' => null];
            $void        = 1;
        }

        $ofRound  = $playerCount + $void;
        $setRound = "Round $round (of $ofRound)";

        if (ceil(log($checkPlayersCountMax, 2.0)) == (double) $round) {
            $setRound = "Super Final Round";
        }
        for ($i = 0; $i < $playerCount / 2; $i++) {
            $matchNumber++;
            $matches[] = [
                'tourney_id'   => $id,
                'player1_id'   => $playerArr[$i]['id'],
                'player2_id'   => $playerArr[$playerCount / 2 + $i + $void]['id'],
                'match_number' => $matchNumber,
                'round_number' => $round,
                'played'       => false,
                'round'        => $setRound,
                'match_type'   => array_search('SINGLE', TourneyList::$matchType),
                'created_at'   => Carbon::now(),
            ];
        }
        try {
            $this->store($matches);

            return $this->redirectToSuccess($round);
        } catch (\Exception $e) {
            \Log::error($e->getMessage());

            return back()->withErrors(['single-match' => $e->errorInfo[2]]);
        }
    }


    private function store($data)
    {
        \DB::table('tourney_matches')->insert($data);
    }

    /**
     * @param $round
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    private function redirectToSuccess($round)
    {
        return back()->with(['single-match-success' => "Матчи для раунда $round успешно созданы"]);
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    private function redirectToError()
    {
        return back()->withErrors(['single-match' => 'Невозможно создать матчи нету игроков.']);
    }


}
