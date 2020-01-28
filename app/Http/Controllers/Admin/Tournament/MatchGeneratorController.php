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
        $tourney     = TourneyList::with('matches')->withCount('checkPlayers')->find($id);
        $type        = TourneyMatch::TYPE_SINGLE;
        $playerCount = $tourney->check_players_count;
        $void        = 0;
        if (($playerCount & 1)) {
            $void = 1;
        }
        $ofRound = $playerCount + $void;
        $rounds  = 0;
        if ( ! empty($ofRound)) {
            $rounds = log($ofRound, 2);
        }


        $content = view('admin.tourneyMatchGenerator.show', compact('rounds', 'type', 'tourney'));

        return AdminSection::view($content, 'Match Generator');
    }

    public function matchGenerator(Request $request)
    {
        if ($request->get('type') === TourneyMatch::TYPE_SINGLE) {
            return $this->single($request->get('id'), $request->get('round'));
        }
        //        $playerCount = $tourney->players->where('check', true)->count();
        //
        //        if ($playerCount == 0) {
        //            return \Response::json([
        //                'success' => false,
        //                'message' => 'Нету игроков',
        //            ], 400);
        //        }
        //        $matches = [];
        //
        //        $players = $tourney->players->where('check', true)->shuffle();
        //
        //        $k = 0;
        //        if (($playerCount & 1)) {
        //            $players[] = ['id' => null];
        //            $k         = 1;
        //        }
        //        $ofRound = $playerCount + $k;
        //        /*** Generate***/
        //        //        $rounds = log($ofRound, 2);
        //
        //        for ($i = 0; $i < $playerCount / 2; $i++) {
        //            $matches[] = [
        //                'tourney_id'   => $tourney['id'],
        //                'player1_id'   => $players[$i]['id'],
        //                'player2_id'   => $players[$playerCount / 2 + $i + $k]['id'],
        //                'round_number' => $round_number,
        //                'played'       => false,
        //                'round'        => "Round $round_number (of $ofRound)",
        //            ];
        //        }
        //
        //        dd($matches);
    }


    /**
     * Single-elimination tournament
     *
     * @param  int  $id
     * @param  null  $round
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    private function single(int $id, $round = null)
    {
        if ($round == 1) {
            return $this->single_round_1($id, $round);
        }

        return $this->single_round_other($id, $round);
    }

    private function single_round_1(int $id, $round)
    {
        $tourney     = TourneyList::with('checkPlayers')
            ->withCount('checkPlayers')
            ->find($id);
        $playerCount = $tourney->check_players_count;

        if ($playerCount == 0) {
            return back()->withErrors(['single-match' => 'Невозможно создать матчи нету игроков.']);
        }
        $matches = [];
        $players = $tourney->checkPlayers->shuffle();

        $void = 0;

        if (($playerCount & 1)) {
            $players[] = ['id' => null];
            $void      = 1;
        }

        $ofRound = $playerCount + $void;

        for ($i = 0; $i < $playerCount / 2; $i++) {
            $matches[] = [
                'tourney_id'   => $tourney['id'],
                'player1_id'   => $players[$i]['id'],
                'player2_id'   => $players[$playerCount / 2 + $i + $void]['id'],
                'match_number' => $i + 1,
                'round_number' => $round,
                'played'       => false,
                'round'        => "Round $round (of $ofRound)",
                'match_type'   => array_search('SINGLE', TourneyList::$matchType),
                'created_at'   => Carbon::now(),
            ];
        }

        $this->store($matches);

        return back()->with(['single-match-success' => "Матчи  для раунда $round успешно созданы"]);
    }

    private function single_round_other(int $id, $round)
    {
        $player1 = TourneyMatch::query()
            ->where('tourney_id', $id)
            ->where('round_number', $round - 1)
            ->where('played', true)
            ->where('player1_score', '>', \DB::raw('player2_score'))
            ->get(['id', 'tourney_id', 'player1_id', 'player1_score', 'player2_score', 'round_number', 'played']);
        $player2 = TourneyMatch::query()
            ->where('tourney_id', $id)
            ->where('round_number', $round - 1)
            ->where('played', true)
            ->where('player2_score', '>', \DB::raw('player1_score'))
            ->get(['id', 'tourney_id', 'player2_id', 'player1_score', 'player2_score', 'round_number', 'played']);

        $players = $player1->merge($player2);

        if ($players->isEmpty()) {
            return redirect()->back()->withErrors(['single-match' => 'Невозможно создать матчи нету игроков.']);
        }
        $playerCount = $players->count();
        $players     = $players->shuffle();

        foreach ($players as $item) {
            if (isset($item['player1_id'])) {
                $playerArr[] = ['id' => $item->player1_id];
            }
            if (isset($item['player2_id'])) {
                $playerArr[] = ['id' => $item->player2_id];
            }
        }

        $void = 0;

        if (($playerCount & 1)) {
            $playerArr[] = ['id' => null];
            $void        = 1;
        }

        $ofRound = $playerCount + $void;
//        dd($playerArr);
//        dd($playerCount);
//
//        foreach ($players as $item) {
//            if ($item->player1_score > $item->player2_score) {
//                $player1[] = ['id' => $item->player1_id,];
//            }
//            if ($item->player2_score > $item->player1_score) {
//                $player2[] = ['id' => $item->player2_id,];
//            }
//        }
//        $players = array_merge($player1, $player2);
//
//        dd($players);
    }


    private function store($data)
    {
        \DB::table('tourney_matches')->insert($data);
    }

}
