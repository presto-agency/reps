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
        DB::connection('mysql3')->table('lis_tourney_match')
            ->chunkById(100, function ($repsTournamentsMatches) {
                try {
                    foreach ($repsTournamentsMatches as $item) {
                        if (TourneyList::query()->where('id', $item->id_tourney)->exists()) {
                            $insertItems[] = [
                                'id'            => $item->id,
                                'tourney_id'    => $item->id_tourney,
                                'player1_id'    => $this->getPlayer1Id($item),
                                'player2_id'    => $this->getPlayer2Id($item),
                                'player1_score' => (int) $item->score_player1,
                                'player2_score' => (int) $item->score_player2,
                                'winner_score'  => (int) $item->score_win,
                                'winner_action' => array_search($item->winner_action, TourneyMatch::$action),
                                'winner_value'  => (int) $item->winner_value,
                                'looser_action' => array_search($item->looser_action, TourneyMatch::$action),
                                'looser_value'  => (int) $item->looser_value,
                                'match_number'  => (int) $item->id_match,
                                'round_number'  => (int) $item->round_id,
                                'played'        => ($item->played == 'YES') ? 1 : 0,
                                'round'         => (string) $item->round,
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
                    DB::table('tourney_matches')->insert($insertItems);
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

