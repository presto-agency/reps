<?php

use App\Models\TourneyList;
use App\Models\TourneyMatch;
use Illuminate\Database\Seeder;

class TransferTournamentsMatches extends Seeder
{


    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /**
         * Clear table
         */
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        DB::table('tourney_matches')->truncate();


        /**
         * Get and Insert data
         */
        DB::connection('mysql3')->table('lis_tourney_match')->orderBy('id')
            ->chunk(100, function ($repsTournamentsMatches) {
                try {
                    foreach ($repsTournamentsMatches as $item) {
                        if (TourneyList::query()->where('id', $item->id_tourney)->exists()) {
                            $winner_score    = $item->score_win !== '' ? $item->score_win : null;
                            $winner_action_s = array_search(trim($item->winner_action), TourneyMatch::$action);
                            $winner_action   = $winner_action_s !== false ? $winner_action_s : null;
                            $winner_value    = $item->winner_value !== '' ? $item->score_win : null;
                            $looser_action_s = array_search(trim($item->looser_action), TourneyMatch::$action);
                            $looser_action   = $looser_action_s !== false ? $looser_action_s : null;
                            $looser_value    = $item->looser_value !== '' ? $item->score_win : null;
                            $match_number    = $item->id_match !== '' ? $item->id_match : null;
                            $round_number    = $item->round_id !== '' ? $item->round_id : null;


                            $insertItems[] = [
                                'tourney_id'    => $item->id_tourney,
                                'player1_id'    => $this->getPlayer1Id($item),
                                'player2_id'    => $this->getPlayer2Id($item),
                                'player1_score' => $item->score_player1,
                                'player2_score' => $item->score_player2,
                                'winner_score'  => $winner_score,
                                'winner_action' => $winner_action,
                                'winner_value'  => $winner_value,
                                'looser_action' => $looser_action,
                                'looser_value'  => $looser_value,
                                'match_number'  => $match_number,
                                'round_number'  => $round_number,
                                'played'        => ($item->played == 'YES') ? 1 : 0,
                                'round'         => $item->round,
                                'rep1'          => ! empty($item->rep1) === true ? '/storage/tourney/'.$item->rep1 : null,
                                'rep2'          => ! empty($item->rep2) === true ? '/storage/tourney/'.$item->rep2 : null,
                                'rep3'          => ! empty($item->rep3) === true ? '/storage/tourney/'.$item->rep3 : null,
                                'rep4'          => ! empty($item->rep4) === true ? '/storage/tourney/'.$item->rep4 : null,
                                'rep5'          => ! empty($item->rep5) === true ? '/storage/tourney/'.$item->rep5 : null,
                                'rep6'          => ! empty($item->rep6) === true ? '/storage/tourney/'.$item->rep6 : null,
                                'rep7'          => ! empty($item->rep7) === true ? '/storage/tourney/'.$item->rep7 : null,
                            ];
                        }
                    }
                    TourneyMatch::query()->insert($insertItems);
                } catch (\Exception $e) {
                    dd($e, $item);
                }
            });
        DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }


    /**
     * @param $item
     *
     * @return mixed|null
     */
    private function getPlayer1Id($item)
    {
        /**
         * Get userLogin with old userId
         */
        $player1Login = DB::connection('mysql3')->table('user')
            ->where('id', $item->id_player1)->value('login');
        /**
         * get player1Id with userLogin
         */
        $getPlayer1Id = DB::table('users')->where('name', trim($player1Login))->value('id');
        if ( ! empty($getPlayer1Id)) {
            $player1Id = DB::table('tourney_players')
                ->where('tourney_id', $item->id_tourney)
                ->where('user_id', $getPlayer1Id)
                ->value('id');
            if ( ! empty($player1Id)) {
                return $player1Id;
            }
        }

        return null;
    }

    /**
     * @param $item
     *
     * @return mixed|null
     */
    private function getPlayer2Id($item)
    {
        /**
         * Get userLogin with old userId
         */
        $player2Login = DB::connection('mysql3')->table('user')
            ->where('id', $item->id_player2)->value('login');
        /**
         * get player1Id with userLogin
         */
        $getPlayer2Id = DB::table('users')->where('name', trim($player2Login))->value('id');
        if ( ! empty($getPlayer2Id)) {
            $player2Id = DB::table('tourney_players')
                ->where('tourney_id', $item->id_tourney)
                ->where('user_id', $getPlayer2Id)
                ->value('id');
            if ( ! empty($player2Id)) {
                return $player2Id;
            }
        }

        return null;
    }

}

