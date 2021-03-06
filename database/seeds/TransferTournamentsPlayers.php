<?php

use App\Models\TourneyList;
use Illuminate\Database\Seeder;

class TransferTournamentsPlayers extends Seeder
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
        DB::table('tourney_players')->truncate();

        /**
         * Get and Insert data
         */
        DB::connection('mysql3')->table('lis_tourney_player')
            ->chunkById(100, function ($repsTournamentsPlayers) {
                try {
                    $insertItems = [];

                    foreach ($repsTournamentsPlayers as $item) {
                        if (TourneyList::query()->where('id', $item->id_tourney)->exists()) {
                            /**
                             * Get UserId
                             */

                            $insertItems[] = [
                                'id'           => $item->id,
                                'tourney_id'   => $item->id_tourney,
                                'user_id'      => $this->getUserId($item),
                                'check'        => $item->checkin == 'YES' ? 1 : 0,
                                'description'  => $item->description,
                                'place_result' => $item->place_result != '' ? $item->place_result : null,
                            ];
                        }
                    }
                    DB::table('tourney_players')->insert($insertItems);
                } catch (\Exception $e) {
                    dd($e, $item);
                }
            });
        DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }

    private function getUserId($item)
    {
        $userLogin = DB::connection('mysql3')->table('user')->where('id', $item->id_user)->value('login');
        $userId    = DB::table('users')->where('name', trim($userLogin))->value('id');
        if (empty($userId)) {
            return DB::table('users')->where('name', 'Anon')->value('id');
        }

        return $userId;
    }

}
