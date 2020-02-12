<?php

namespace App\Http\Controllers\admin\Tournament;

use AdminSection;
use App\Http\Controllers\Controller;
use App\Http\Requests\MatchGeneratorRequest;
use App\Models\TourneyList;
use App\Models\TourneyMatch;
use Carbon\Carbon;


class MatchGeneratorController extends Controller
{

    public function show(int $id)
    {
        $tourney = TourneyList::query()->withCount('matches', 'checkPlayers')->findOrFail($id);
        $data    = [];
        if ($tourney->type == $tourney::TYPE_SINGLE) {
            $data = $this->data($tourney);
        }
        if ($tourney->type == $tourney::TYPE_DOUBLE) {
            $data = $this->data($tourney, 1);
        }

        $content = view('admin.tourneyMatchGenerator.show', compact('tourney', 'data'));

        return AdminSection::view($content, 'Генератор матчей');
    }

    /**
     * Rounds
     *
     * @param $tourney
     * @param  int  $key
     *
     * @return array
     */
    private function data($tourney, $key = 0)
    {
        $playerCount = $tourney->check_players_count;
        $void        = 0;

        if (($playerCount & 1)) {
            $void = 1;
        }
        $ofRound = $playerCount + $void;

        $rounds = [];
        if ($ofRound != 0) {
            if ($tourney->type == $tourney::TYPE_SINGLE) {
                $rounds['allPlayers']       = $ofRound;
                $rounds['roundsCanCreate']  = ceil(log($ofRound, 2.0));
                $rounds['roundsNowCreate']  = TourneyMatch::query()->where('tourney_id', $tourney->id)->distinct('round_number')->count();
                $rounds['roundsLeftCreate'] = $rounds['roundsCanCreate'] - $rounds['roundsNowCreate'];
                for ($i = 1; $i <= $rounds['roundsCanCreate']; $i++) {
                    $rounds['rounds'][] = [
                        'number'        => $i,
                        'exist'         => TourneyMatch::query()->where('tourney_id', $tourney->id)->where('round_number', $i)->exists(),
                        'previousExist' => TourneyMatch::query()->where('tourney_id', $tourney->id)->where('round_number', '<', $i)->exists(),
                    ];
                }
            } else {
                $round_number              = TourneyMatch::query()->where('tourney_id', $tourney->id)->max('round_number');
                $round_number              = ! empty($round_number) ? $round_number : 1;
                $rounds['allPlayers']      = $ofRound;
                $rounds['roundsNowCreate'] = TourneyMatch::query()->where('tourney_id', $tourney->id)->distinct('round_number')->count();
                $rounds['rounds'][]        = [
                    'number'     => $round_number,
                    'nextNumber' => $round_number + 1,
                    'exist'      => TourneyMatch::query()->where('tourney_id', $tourney->id)->where('round_number', $round_number)->exists(),
                    'nextExist'  => TourneyMatch::query()->where('tourney_id', $tourney->id)->where('round_number', $round_number + 1)->exists(),
                ];
            }
        }


        return $rounds;
    }


    /**
     * @param  \App\Http\Requests\MatchGeneratorRequest  $request
     *
     * @return \Illuminate\Http\RedirectResponse|null
     */
    public function matchGenerator(MatchGeneratorRequest $request)
    {
        $tourney = TourneyList::with('checkPlayers')
            ->withCount('checkPlayers')
            ->where('status', array_search('STARTED', TourneyList::$status))
            ->findOrFail($request->get('id'));
        if ($request->get('type') == TourneyList::TYPE_DOUBLE) {
            return $this->double($tourney, $request->get('round'), $request->get('allPlayers'));
        }

        return $this->single($tourney, $request->get('round'));
    }

    /**
     * @param $tourney
     * @param $round
     * @param $allPlayers
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    private function double($tourney, $round, int $allPlayers = null)
    {
        if ($round == 1) {
            return $this->round_1($tourney, $round);
        } elseif ($round == 2) {
            return $this->round_2($tourney->id, $round);
        } else {
            return $this->round_other($tourney->id, $round);
        }
    }

    private function round_2(int $id, $round)
    {
        $playersWAW = $this->allWinnersAmongWinners($id, $round);
        $playersLAW = $this->allLosersAmongWinners($id, $round);

        if ($playersWAW->isEmpty() && $playersLAW->isEmpty()) {
            return back()->withErrors(['single-match' => 'Невозможно создать матчи нету игроков.']);
        }
        if ($playersWAW->isNotEmpty()) {
            $matchNumber = $this->matchNumber($id);

            $matchesWAW = $this->matchesDouble($id, $round, $matchNumber, $playersWAW, 1, 'for winners');

            try {
                \DB::table('tourney_matches')->insert($matchesWAW);
            } catch (\Exception $e) {
                \Log::error($e->getMessage());

                return back()->withErrors(['single-match' => "Ошибка при создании матчей для раунда $round"]);
            }
        }
        if ($playersLAW->isNotEmpty()) {
            $matchNumber = $this->matchNumber($id);
            $matchesLAW  = $this->matchesDouble($id, $round, $matchNumber, $playersLAW, 2, 'for losers');
            try {
                \DB::table('tourney_matches')->insert($matchesLAW);
            } catch (\Exception $e) {
                \Log::error($e->getMessage());

                return back()->withErrors(['single-match' => "Ошибка при создании матчей для раунда $round"]);
            }
        }

        return back()->with(['single-match-success' => "Матчи для раунда $round успешно созданы"]);
    }

    private function round_other(int $id, $round)
    {
        $playersWAW    = $this->allWinnersAmongWinners($id, $round);
        $playersLAW    = $this->allLosersAmongWinners($id, $round);
        $playersWAL    = $this->allWinnersAmongLosers($id, $round);
        $playersLAWWAL = $playersLAW->merge($playersWAL);

        if ($playersWAW->isEmpty() && $playersLAWWAL->isEmpty()) {
            return back()->withErrors(['single-match' => 'Невозможно создать матчи нету игроков.']);
        }
        if ($playersWAW->count() > 1) {
            dd(1);
            $matchNumber = $this->matchNumber($id);

            $matchesWAW = $this->matchesDouble($id, $round, $matchNumber, $playersWAW, 1, 'for winners');

            try {
                \DB::table('tourney_matches')->insert($matchesWAW);
            } catch (\Exception $e) {
                \Log::error($e->getMessage());

                return back()->withErrors(['single-match' => "Ошибка при создании матчей победителей для раунда $round"]);
            }
        }

        if ($playersLAWWAL->count() > 1) {
            dd(2);
            $matchNumber  = $this->matchNumber($id);
            $matchesLAWWA = $this->matchesDouble($id, $round, $matchNumber, $playersLAWWAL, 2, 'for losers');
            try {
                \DB::table('tourney_matches')->insert($matchesLAWWA);
            } catch (\Exception $e) {
                \Log::error($e->getMessage());

                return back()->withErrors(['single-match' => "Ошибка при создании матчей проигравших для раунда $round"]);
            }
        }
        if ($playersWAW->count() == 1 && $playersLAWWAL->count() == 1) {
            $playersWAWLAWWAL = $playersWAW->merge($playersLAWWAL);
            dd($playersWAWLAWWAL);
        }

        return back()->with(['single-match-success' => "Матчи для раунда $round успешно созданы"]);
    }

    /**
     * @param $id
     * @param $round
     * @param $matchNumber
     * @param $players
     * @param  int  $branch
     * @param  string  $for
     *
     * @return array
     */
    private function matchesDouble($id, $round, $matchNumber, $players, $branch = 1, $for = '')
    {
        $matches     = [];
        $players     = $players->shuffle();
        $playerCount = $players->count();
        $playerArr   = $this->playerArr($players, $playerCount);
        $void        = ($playerCount & 1) == true ? 1 : 0;

        $setRound = $this->setRound($playerCount, $void, $for, $round);


        for ($i = 0; $i < $playerCount / 2; $i++) {
            $matchNumber++;
            $matches[] = [
                'tourney_id'   => $id,
                'player1_id'   => $playerArr[$i]['id'],
                'player2_id'   => $playerArr[$playerCount / 2 + $i + $void]['id'],
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

    /**
     * @param $playerCount
     * @param $void
     * @param $for
     * @param $round
     *
     * @return string
     */
    private function setRound($playerCount, $void, $for, $round)
    {
        $ofRound = $playerCount + $void;

        return "Round $for $round (of $ofRound)";
    }

    /**
     * @param $players
     * @param $playerCount
     *
     * @return array
     */
    private function playerArr($players, $playerCount)
    {
        $playerArr = [];
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

        if (($playerCount & 1)) {
            $playerArr[] = ['id' => null];
        }

        return $playerArr;
    }

    /**
     * Single-elimination tournament
     *
     * @param  $tourney
     * @param  $round
     *
     * @return null
     */
    private function single($tourney, $round)
    {
        if ($round == 1) {
            return $this->round_1($tourney, $round);
        } else {
            return $this->single_round_other($tourney->id, $round);
        }
    }

    /**
     * @param $tourney
     * @param $round
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    private function round_1($tourney, $round)
    {
        if ($tourney->check_players_count == 0) {
            return back()->withErrors(['single-match' => 'Невозможно создать матчи нету игроков.']);
        }
        $matches     = [];
        $playerCount = $tourney->check_players_count;
        $players     = $tourney->checkPlayers->shuffle();
        $void        = 0;
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
                'created_at'   => Carbon::now(),
            ];
        }

        return $this->save($matches, $round);
    }

    /**
     * @param  int  $id
     * @param $round
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    private function single_round_other(int $id, $round)
    {
        /**
         * Get all winner Player1 & Player2
         */
        $player1 = TourneyMatch::query()
            ->whereNotNull('player1_id')
            ->where('tourney_id', $id)
            ->where('round_number', $round - 1)
            ->where('played', true)
            ->where('branch', array_search('branch_winners', TourneyMatch::$branches))
            ->where('player1_score', '>', \DB::raw('player2_score'))
            ->get(['id', 'tourney_id', 'player1_id', 'player1_score', 'player2_score', 'round_number', 'played']);
        $player2 = TourneyMatch::query()
            ->whereNotNull('player2_id')
            ->where('tourney_id', $id)
            ->where('round_number', $round - 1)
            ->where('played', true)
            ->where('branch', array_search('branch_winners', TourneyMatch::$branches))
            ->where('player2_score', '>', \DB::raw('player1_score'))
            ->get(['id', 'tourney_id', 'player2_id', 'player1_score', 'player2_score', 'round_number', 'played']);

        $players = $player1->merge($player2);
        if ($players->isEmpty()) {
            return back()->withErrors(['single-match' => 'Невозможно создать матчи нету игроков.']);
        }

        return $this->matches($id, $round, $players);
    }

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
     *
     *
     * @param $matches
     * @param $round
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    private function save($matches, $round)
    {
        try {
            \DB::table('tourney_matches')->insert($matches);

            return back()->with(['single-match-success' => "Матчи для раунда $round успешно созданы"]);
        } catch (\Exception $e) {
            \Log::error($e->getMessage());

            return back()->withErrors(['single-match' => "Ошибка при создании матчей для раунда $round"]);
        }
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
