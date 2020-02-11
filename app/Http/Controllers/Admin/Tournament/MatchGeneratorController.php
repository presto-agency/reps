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
            ->findOrFail($request->get('id'));
        if ($request->get('type') == TourneyList::TYPE_SINGLE) {
            return $this->single($tourney, $request->get('round'));
        } elseif ($request->get('type') == TourneyList::TYPE_DOUBLE && $request->get('round') == 1) {
            return $this->round_1($tourney, 1);
        } else {
            return back();
        }
    }

    public function matchGeneratorWinners(MatchGeneratorRequest $request)
    {
        if ($request->get('type') == TourneyList::TYPE_DOUBLE) {
            return $this->double($request->get('id'), $request->get('round'));
        } else {
            return back();
        }
    }

    public function matchGeneratorLosers(MatchGeneratorRequest $request)
    {
        $tourney = TourneyList::with('checkPlayers')
            ->withCount('checkPlayers')
            ->findOrFail($request->get('id'));
        if ($request->get('type') == TourneyList::TYPE_DOUBLE) {
            return back();
        } else {
            return back();
        }
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

        $playerCount = $tourney->check_players_count;

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
            ->where('player1_score', '>', \DB::raw('player2_score'))
            ->get(['id', 'tourney_id', 'player1_id', 'player1_score', 'player2_score', 'round_number', 'played']);
        $player2 = TourneyMatch::query()
            ->whereNotNull('player2_id')
            ->where('tourney_id', $id)
            ->where('round_number', $round - 1)
            ->where('played', true)
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
    private function matches($id, $round, $players, $key = null, $for = '')
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
        $setRound = "Round $for $round (of $ofRound)";

        if (ceil(log($checkPlayersCountMax, 2.0) + $key) == (double) $round) {
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

    private function double($id, $round)
    {
        $players = $this->getAllWinners($id, $round);
        if ($players->isEmpty()) {
            return back()->withErrors(['single-match' => 'Невозможно создать матчи нету игроков.']);
        }

        return $this->matches($id, $round, $players, 1.0, 'for winners');
    }

    private function getAllWinners($id, $round)
    {
        $player1 = TourneyMatch::with('player1:id,defeat')
            ->whereNotNull('player1_id')
            ->whereHas('player1', function ($q) {
                $q->where('defeat', 0);
            })->where('tourney_id', $id)
            ->where('round_number', $round)
            ->where('played', true)
            ->where('player1_score', '>', \DB::raw('player2_score'))
            ->get(['id', 'tourney_id', 'player1_id', 'player1_score', 'player2_score', 'round_number', 'played']);
        $player2 = TourneyMatch::with('player2:id,defeat')
            ->whereNotNull('player2_id')
            ->whereHas('player2', function ($q) {
                $q->where('defeat', 0);
            })->where('tourney_id', $id)
            ->where('round_number', $round)
            ->where('played', true)
            ->where('player2_score', '>', \DB::raw('player1_score'))
            ->get(['id', 'tourney_id', 'player2_id', 'player1_score', 'player2_score', 'round_number', 'played']);
        dd($player1, $player2);

        return $player1->merge($player2);
    }

    private function double_matches_winners($id, $round, $players)
    {
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

}
