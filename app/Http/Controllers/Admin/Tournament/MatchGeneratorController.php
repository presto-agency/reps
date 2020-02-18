<?php

namespace App\Http\Controllers\admin\Tournament;

use AdminSection;
use App\Http\Controllers\Controller;
use App\Http\Requests\MatchGeneratorRequest;
use App\Models\TourneyList;
use App\Models\TourneyMatch;
use App\Services\MatchGenerator\TourneyDouble;
use App\Services\MatchGenerator\TourneySingle;
use stdClass;


class MatchGeneratorController extends Controller
{

    /**
     * @param  int  $id
     *
     * @return mixed
     */
    public function show(int $id)
    {
        $tourney = TourneyList::query()->withCount('matches', 'checkPlayers', 'checkDefeat0Players', 'checkDefeat1Players', 'checkDefeat2Players')->findOrFail($id);
        $data    = TourneyList::getGeneratorData($tourney);
        $content = view('admin.tourneyMatchGenerator.show', compact('tourney', 'data'));
        /**
         * Data players winners & lossers
         */
        $playersWAW = TourneyMatch::getWinnersAmongWinners($tourney->id, end($data['rounds'])['roundNumber'])->shuffle();
        $playersLAW = TourneyMatch::getLosersAmongWinners($tourney->id, end($data['rounds'])['roundNumber'])->shuffle();
        $playersWAL = TourneyMatch::getWinnersAmongLosers($tourney->id, end($data['rounds'])['roundNumber'])->shuffle();

        /**
         * Check data players  for finals
         */
        $playersFR = TourneyMatch::getFinalsRound($tourney->id, end($data['rounds'])['roundNumber']);

        $waf        = new stdClass();
        $laf        = new stdClass();
        $playersWAF = collect();
        $playersLAF = collect();
        if ( ! empty($playersFR)) {
            if ($playersFR->checkPlayers1->defeat < 2) {
                $waf->player1_id = $playersFR->player1_id;
                $playersWAF[]    = $waf;
            }
            if ($playersFR->checkPlayers2->defeat < 2) {
                $laf->player2_id = $playersFR->player2_id;
                $playersLAF[]    = $laf;
            }
        }

        /**
         * Check players 1
         */
        $playersWAFLAF = $playersWAF->merge($playersLAF);
        dd($playersWAFLAF, $playersWAW, $playersLAW, $playersWAL);

        return AdminSection::view($content, 'Генератор матчей');
    }


    /**
     * @param  \App\Http\Requests\MatchGeneratorRequest  $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function matchGenerator(MatchGeneratorRequest $request)
    {
        $round       = (int) $request->get('round');
        $type        = (int) $request->get('type');
        $getTourney  = TourneyList::getStartedTourneyWithPlayers($request->get('id'));
        $playerCount = $getTourney->check_players_count;

        if ($playerCount < 1) {
            return $this->redirectNoPlayers();
        }
        $players = $getTourney->checkPlayers->shuffle();

        /**
         * Single
         */
        if ($type == TourneyList::TYPE_SINGLE) {
            if ($round > 0 && $round < 2) {
                $matches = TourneySingle::roundOneMatches($getTourney->id, $round, $players, $playerCount);

                return TourneySingle::save($matches, $round);
            }

            if ($round > 1) {
                $players = TourneySingle::getPlayers($getTourney->id, $round)->shuffle();
                if ($players->isEmpty()) {
                    return $this->redirectNoPlayers();
                }
                $matchNumber = TourneyMatch::getMaxMatchNumber($getTourney->id, $round);

                $matches = TourneySingle::roundNextMatches($getTourney->id, $matchNumber, $round, $players, $playerCount);

                return TourneySingle::save($matches, $round);
            }
        }
        /**
         * Double
         */
        if ($type == TourneyList::TYPE_DOUBLE) {
            if ($round > 0 && $round < 2) {
                $matches = TourneySingle::roundOneMatches($getTourney->id, $round, $players, $playerCount);

                return TourneySingle::save($matches, $round);
            } elseif ($round > 1) {
                /**
                 * Data players winners & lossers
                 */
                $playersWAW = TourneyMatch::getWinnersAmongWinners($getTourney->id, $round)->shuffle();
                $playersLAW = TourneyMatch::getLosersAmongWinners($getTourney->id, $round)->shuffle();
                $playersWAL = TourneyMatch::getWinnersAmongLosers($getTourney->id, $round)->shuffle();

                /**
                 * Check data players  for finals
                 */
                $playersFR = TourneyMatch::getFinalsRound($getTourney->id, $round);

                $waf        = new stdClass();
                $laf        = new stdClass();
                $playersWAF = collect();
                $playersLAF = collect();
                if ( ! empty($playersFR)) {
                    if ($playersFR->checkPlayers1->defeat < 2) {
                        $waf->player1_id = $playersFR->player1_id;
                        $playersWAF[]    = $waf;
                    }
                    if ($playersFR->checkPlayers2->defeat < 2) {
                        $laf->player2_id = $playersFR->player2_id;
                        $playersLAF[]    = $laf;
                    }
                }

                /**
                 * Check players 1
                 */
                $playersWAFLAF = $playersWAF->merge($playersLAF);
                if ($playersWAW->isEmpty() && $playersLAW->isEmpty() && $playersWAL->isEmpty() && $playersWAFLAF->isEmpty()) {
                    return $this->redirectNoPlayers();
                }
                /**
                 * Check players 2
                 */
                $playersWAWCount    = $playersWAW->count();
                $playersLAWCount    = $playersLAW->count();
                $playersWALCount    = $playersWAL->count();
                $playersWAFLAFCount = $playersWAFLAF->count();

                if ($playersWAWCount + $playersLAWCount + $playersWALCount + $playersWAFLAFCount < 2) {
                    return $this->redirectNoPlayers();
                }
                $playersLAWWAL      = $playersLAW->merge($playersWAL);
                $playersLAWWALCount = $playersLAWCount + $playersWALCount;
                $matchNumber        = TourneyMatch::getMaxMatchNumber($getTourney->id, $round);

                /**
                 * For super final round
                 */
                if ($playersWAWCount == 1 && $playersLAWWALCount == 1) {
                    $players      = $playersWAW->merge($playersLAWWAL);
                    $playersCount = $players->count();

                    if ($playersCount === 1) {
                        $p1       = new stdClass();
                        $p2       = new stdClass();
                        $players1 = collect();
                        $players2 = collect();

                        if ( ! empty($playersWAW->first()) && ! empty($playersLAWWAL->first())) {
                            if (isset($playersWAW->first()->checkPlayers1) && $playersWAW->first()->checkPlayers1->defeat < 2) {
                                $p1->player1_id = $playersWAW->first()->player1_id;
                                $players1[]     = $p1;
                            }
                            if (isset($playersWAW->first()->checkPlayers2) && $playersWAW->first()->checkPlayers2->defeat < 2) {
                                $p1->player1_id = $playersWAW->first()->player2_id;
                                $players1[]     = $p1;
                            }
                            if (isset($playersLAWWAL->first()->checkPlayers1) && $playersLAWWAL->first()->checkPlayers1->defeat < 2) {
                                $p2->player2_id = $playersLAWWAL->first()->player1_id;
                                $players2[]     = $p2;
                            }
                            if (isset($playersLAWWAL->first()->checkPlayers2) && $playersLAWWAL->first()->checkPlayers2->defeat < 2) {
                                $p2->player2_id = $playersLAWWAL->first()->player2_id;
                                $players2[]     = $p2;
                            }
                            $players = $players1->merge($players2);
                        }
                    }
                    $matches = TourneyDouble::roundTwoMatches($getTourney->id, $round, $matchNumber, $players, $playersCount, array_search('finals', TourneyMatch::$branches), 'Super Final Round');

                    return TourneySingle::save($matches, $round);
                } elseif ($playersWAFLAFCount == 2) {
                    $matches = TourneyDouble::roundTwoMatches($getTourney->id, $round, $matchNumber, $playersWAFLAF, $playersWAFLAFCount, array_search('finals', TourneyMatch::$branches), 'Super Final Round');

                    return TourneySingle::save($matches, $round);
                }
                /**
                 * For other round
                 */
                $matches1 = TourneyDouble::roundTwoMatches($getTourney->id, $round, $matchNumber, $playersWAW, $playersWAWCount, array_search('winners', TourneyMatch::$branches), 'Winners');
                if ( ! empty($matches1)) {
                    $matchNumber = end($matches1)['match_number'];
                }
                $matches2 = TourneyDouble::roundTwoMatches($getTourney->id, $round, $matchNumber, $playersLAWWAL, $playersLAWWALCount, array_search('losers', TourneyMatch::$branches), 'Losers');
                $matches  = array_merge($matches1, $matches2);


                return TourneySingle::save($matches, $round);
            }
        }

        return back();
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function redirectNoPlayers()
    {
        return back()->withErrors(['single-match' => 'Невозможно создать матчи нехватает игроков.']);
    }

}
