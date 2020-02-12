<?php

namespace App\Http\Controllers\admin\Tournament;

use AdminSection;
use App\Http\Controllers\Controller;
use App\Http\Requests\MatchGeneratorRequest;
use App\Models\TourneyList;
use App\Models\TourneyMatch;
use App\Services\MatchGenerator\TourneySingle;
use Carbon\Carbon;


class MatchGeneratorController extends Controller
{

    /**
     * @param  int  $id
     *
     * @return mixed
     */
    public function show(int $id)
    {
        $tourney = TourneyList::query()->withCount('matches', 'checkPlayers')->findOrFail($id);
        $data    = TourneyList::getGeneratorData($tourney);

        $content = view('admin.tourneyMatchGenerator.show', compact('tourney', 'data'));

        return AdminSection::view($content, 'Генератор матчей');
    }


    public function matchGenerator(MatchGeneratorRequest $request)
    {
        $getTourney  = TourneyList::getStartedTourneyWithPlayers($request->get('id'));
        $playerCount = $getTourney->check_players_count;
        if ($playerCount < 1) {
            return back()->withErrors(['single-match' => 'Невозможно создать матчи нету игроков.']);
        }
        $round = $request->get('round');
        $type  = $request->get('type');

        if ($type == TourneyList::TYPE_SINGLE) {
            if ($round == 1) {
                $matches = TourneySingle::roundOneMatches($getTourney->id, $round, $playerCount, $getTourney->checkPlayers->shuffle());

                return TourneySingle::save($matches, $round);
            }

            if ($round > 1) {
                $players = TourneySingle::getPlayers($getTourney->id, $round)->shuffle();
                if ($players->isEmpty()) {
                    return back()->withErrors(['single-match' => 'Невозможно создать матчи нету игроков.']);
                }
                $matchNumber = TourneyMatch::getMaxMatchNumber($getTourney->id, $round);

                $matches = TourneySingle::roundNextMatches($getTourney->id, $matchNumber, $round, $players, $playerCount);

                return TourneySingle::save($matches, $round);
            }
        }
        //        if ($request->get('type') == TourneyList::TYPE_DOUBLE) {
        //            return $this->double($tourney, $request->get('round'), $request->get('allPlayers'));
        //
        //        }
    }


    //    private function double($tourney, $round, int $allPlayers = null)
    //    {
    //        if ($round == 1) {
    //            return $this->round_1($tourney, $round);
    //        } elseif ($round == 2) {
    //            return $this->round_2($tourney->id, $round);
    //        } else {
    //            return $this->round_other($tourney->id, $round);
    //        }
    //    }

    //    private function round_2(int $id, $round)
    //    {
    //        $playersWAW = $this->allWinnersAmongWinners($id, $round);
    //        $playersLAW = $this->allLosersAmongWinners($id, $round);
    //
    //        if ($playersWAW->isEmpty() && $playersLAW->isEmpty()) {
    //            return back()->withErrors(['single-match' => 'Невозможно создать матчи нету игроков.']);
    //        }
    //        if ($playersWAW->isNotEmpty()) {
    //            $matchNumber = $this->matchNumber($id);
    //
    //            $matchesWAW = $this->matchesDouble($id, $round, $matchNumber, $playersWAW, 1, 'for winners');
    //
    //            try {
    //                \DB::table('tourney_matches')->insert($matchesWAW);
    //            } catch (\Exception $e) {
    //                \Log::error($e->getMessage());
    //
    //                return back()->withErrors(['single-match' => "Ошибка при создании матчей для раунда $round"]);
    //            }
    //        }
    //        if ($playersLAW->isNotEmpty()) {
    //            $matchNumber = $this->matchNumber($id);
    //            $matchesLAW  = $this->matchesDouble($id, $round, $matchNumber, $playersLAW, 2, 'for losers');
    //            try {
    //                \DB::table('tourney_matches')->insert($matchesLAW);
    //            } catch (\Exception $e) {
    //                \Log::error($e->getMessage());
    //
    //                return back()->withErrors(['single-match' => "Ошибка при создании матчей для раунда $round"]);
    //            }
    //        }
    //
    //        return back()->with(['single-match-success' => "Матчи для раунда $round успешно созданы"]);
    //    }

    //    private function round_other(int $id, $round)
    //    {
    //        $playersWAW    = $this->allWinnersAmongWinners($id, $round);
    //        $playersLAW    = $this->allLosersAmongWinners($id, $round);
    //        $playersWAL    = $this->allWinnersAmongLosers($id, $round);
    //        $playersLAWWAL = $playersLAW->merge($playersWAL);
    //
    //        if ($playersWAW->isEmpty() && $playersLAWWAL->isEmpty()) {
    //            return back()->withErrors(['single-match' => 'Невозможно создать матчи нету игроков.']);
    //        }
    //        if ($playersWAW->count() > 1) {
    //            $matchNumber = $this->matchNumber($id);
    //
    //            $matchesWAW = $this->matchesDouble($id, $round, $matchNumber, $playersWAW, 1, 'for winners');
    //
    //            try {
    //                \DB::table('tourney_matches')->insert($matchesWAW);
    //            } catch (\Exception $e) {
    //                \Log::error($e->getMessage());
    //
    //                return back()->withErrors(['single-match' => "Ошибка при создании матчей победителей для раунда $round"]);
    //            }
    //        }
    //
    //        if ($playersLAWWAL->count() > 1) {
    //            $matchNumber  = $this->matchNumber($id);
    //            $matchesLAWWA = $this->matchesDouble($id, $round, $matchNumber, $playersLAWWAL, 2, 'for losers');
    //            try {
    //                \DB::table('tourney_matches')->insert($matchesLAWWA);
    //            } catch (\Exception $e) {
    //                \Log::error($e->getMessage());
    //
    //                return back()->withErrors(['single-match' => "Ошибка при создании матчей проигравших для раунда $round"]);
    //            }
    //        }
    //        if ($playersWAW->count() == 1 && $playersLAWWAL->count() == 1) {
    //            $matchNumber      = $this->matchNumber($id);
    //            $playersWAWLAWWAL = $playersWAW->merge($playersLAWWAL);
    //
    //            $matchesWAWLAWWAL = $this->matchesDouble($id, $round, $matchNumber, $playersWAWLAWWAL, 2, 'Super Final Round');
    //            try {
    //                \DB::table('tourney_matches')->insert($matchesWAWLAWWAL);
    //            } catch (\Exception $e) {
    //                \Log::error($e->getMessage());
    //
    //                return back()->withErrors(['single-match' => "Ошибка при создании финального раунда $round"]);
    //            }
    //        }
    //
    //        return back()->with(['single-match-success' => "Матчи для раунда $round успешно созданы"]);
    //    }


    //    private function matchesDouble($id, $round, $matchNumber, $players, $branch = 1, $for = '')
    //    {
    //        $matches     = [];
    //        $players     = $players->shuffle();
    //        $playerCount = $players->count();
    //        $playerArr = [];
    //        foreach ($players as $item) {
    //            if (isset($item['player1_id'])) {
    //                $playerArr[] = [
    //                    'id' => $item->player1_id,
    //                ];
    //            }
    //            if (isset($item['player2_id'])) {
    //                $playerArr[] = [
    //                    'id' => $item->player2_id,
    //                ];
    //            }
    //        }
    //
    //        if (($playerCount & 1)) {
    //            $playerArr[] = ['id' => null];
    //        }
    //
    //
    //        $void        = ($playerCount & 1) == true ? 1 : 0;
    //
    //        if ($for != 'Super Final Round') {
    //           $ofRound = $playerCount + $void;
    //
    //            $setRound = "Round $for $round (of $ofRound)";
    //        } else {
    //            $setRound = $for;
    //        }
    //
    //
    //        for ($i = 0; $i < $playerCount / 2; $i++) {
    //            $matchNumber++;
    //            $matches[] = [
    //                'tourney_id'   => $id,
    //                'player1_id'   => $playerArr[$i]['id'],
    //                'player2_id'   => $playerArr[$playerCount / 2 + $i + $void]['id'],
    //                'match_number' => $matchNumber,
    //                'round_number' => (int) $round,
    //                'branch'       => $branch,
    //                'played'       => false,
    //                'round'        => $setRound,
    //                'created_at'   => Carbon::now(),
    //            ];
    //        }
    //
    //        return $matches;
    //    }

    /**
     * @param $id
     * @param $round
     * @param $players
     * @param  null  $key
     * @param  string  $for
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    private function matches($id, $round, $players)
    {
        $matchNumber = TourneyMatch::query()
            ->where('tourney_id', $id)
            ->where('round_number', $round - 1)->max('match_number');

        $players = $players->shuffle();

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
        $checkPlayersCountMax = TourneyList::query()->select(['id'])->withCount('checkPlayers')
            ->where('id', $id)->value('check_players_count');
        $void                 = 0;
        $playerCount          = $players->count();
        if (($playerCount & 1)) {
            $playerArr[] = ['id' => null];
            $void        = 1;
        }

        $ofRound  = $playerCount + $void;
        $setRound = "Round $round (of $ofRound)";

        if (ceil(log($checkPlayersCountMax, 2.0)) == (double) $round) {
            $setRound = "Super Final Round";
        }


        $matches = [];
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
                'created_at'   => Carbon::now(),
            ];
        }

        return $this->save($matches, $round);
    }

    /**
     * @param $id
     * @param $round
     *
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Query\Builder[]|\Illuminate\Support\Collection
     */
    private function allWinnersAmongWinners($id, $round)
    {
        $player1 = TourneyMatch::with('player1:id,defeat')
            ->whereNotNull('player1_id')
            ->whereHas('player1', function ($q) {
                $q->where('defeat', 0);
            })->where('tourney_id', $id)
            ->where('round_number', $round - 1)
            ->where('branch', array_search('winners', TourneyMatch::$branches))
            ->where('played', true)
            ->where('player1_score', '>', \DB::raw('player2_score'))
            ->get(['id', 'tourney_id', 'player1_id', 'player1_score', 'player2_score', 'round_number', 'played', 'branch']);
        $player2 = TourneyMatch::with('player2:id,defeat')
            ->whereNotNull('player2_id')
            ->whereHas('player2', function ($q) {
                $q->where('defeat', 0);
            })->where('tourney_id', $id)
            ->where('round_number', $round - 1)
            ->where('branch', array_search('winners', TourneyMatch::$branches))
            ->where('played', true)
            ->where('player2_score', '>', \DB::raw('player1_score'))
            ->get(['id', 'tourney_id', 'player2_id', 'player1_score', 'player2_score', 'round_number', 'played', 'branch']);

        return $player1->merge($player2);
    }

    /**
     * @param $id
     * @param $round
     *
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Query\Builder[]|\Illuminate\Support\Collection
     */
    private function allLosersAmongWinners($id, $round)
    {
        $player1 = TourneyMatch::with('player1:id,defeat')
            ->whereNotNull('player1_id')
            ->whereHas('player1', function ($q) {
                $q->where('defeat', 1);
            })->where('tourney_id', $id)
            ->where('round_number', $round - 1)
            ->where('branch', array_search('winners', TourneyMatch::$branches))
            ->where('played', true)
            ->where('player1_score', '<', \DB::raw('player2_score'))
            ->get(['id', 'tourney_id', 'player1_id', 'player1_score', 'player2_score', 'round_number', 'played', 'branch']);
        $player2 = TourneyMatch::with('player2:id,defeat')
            ->whereNotNull('player2_id')
            ->whereHas('player2', function ($q) {
                $q->where('defeat', 1);
            })->where('tourney_id', $id)
            ->where('round_number', $round - 1)
            ->where('branch', array_search('winners', TourneyMatch::$branches))
            ->where('played', true)
            ->where('player2_score', '<', \DB::raw('player1_score'))
            ->get(['id', 'tourney_id', 'player2_id', 'player1_score', 'player2_score', 'round_number', 'played', 'branch']);

        return $player1->merge($player2);
    }

    /**
     * @param $id
     * @param $round
     *
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Query\Builder[]|\Illuminate\Support\Collection
     */
    private function allWinnersAmongLosers($id, $round)
    {
        $player1 = TourneyMatch::with('player1:id,defeat')
            ->whereNotNull('player1_id')
            ->whereHas('player1', function ($q) {
                $q->where('defeat', 1);
            })->where('tourney_id', $id)
            ->where('round_number', $round - 1)
            ->where('branch', array_search('losers', TourneyMatch::$branches))
            ->where('played', true)
            ->where('player1_score', '>', \DB::raw('player2_score'))
            ->get(['id', 'tourney_id', 'player1_id', 'player1_score', 'player2_score', 'round_number', 'played', 'branch']);
        $player2 = TourneyMatch::with('player2:id,defeat')
            ->whereNotNull('player2_id')
            ->whereHas('player2', function ($q) {
                $q->where('defeat', 1);
            })->where('tourney_id', $id)
            ->where('round_number', $round - 1)
            ->where('branch', array_search('losers', TourneyMatch::$branches))
            ->where('played', true)
            ->where('player2_score', '>', \DB::raw('player1_score'))
            ->get(['id', 'tourney_id', 'player2_id', 'player1_score', 'player2_score', 'round_number', 'played', 'branch']);

        return $player1->merge($player2);
    }

    /**
     * @param $id
     *
     * @return mixed
     */
    private function matchNumber($id)
    {
        $round_number = TourneyMatch::query()->where('tourney_id', $id)->max('round_number');

        return TourneyMatch::query()
            ->where('tourney_id', $id)
            ->where('round_number', $round_number)->max('match_number');
    }

}
