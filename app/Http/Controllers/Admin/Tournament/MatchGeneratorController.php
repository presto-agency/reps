<?php

namespace App\Http\Controllers\admin\Tournament;

use AdminSection;
use App\Http\Controllers\Controller;
use App\Models\TourneyList;
use App\Models\TourneyMatch;
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
        $tourney     = TourneyList::with('checkPlayers')
            ->withCount('players', 'checkPlayers')
            ->find($id);
        $playerCount = $tourney->check_players_count;

        if (empty($playerCount)) {
            return redirect()->back()->withErrors(['single-match' => 'Невозможно создать матчи нету игроков.']);
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
                'round_number' => $round,
                'played'       => false,
                'round'        => "Round $round (of $ofRound)",
                'match_type'   => array_search('SINGLE', TourneyList::$matchType),
            ];
        }

        $this->store($matches);

        return redirect()->back()->with(['single-match-success' => "Матчи  для раунда $round успешно созданы"]);
    }

    private function store($data)
    {
        TourneyMatch::query()->insertOrIgnore($data);
    }

}
