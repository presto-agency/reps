<?php

use App\Models\TourneyList;
use App\Services\Tournament\TourneyService;
use Illuminate\Database\Seeder;

class TransferTournamentsList extends Seeder
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
        DB::table('tourney_lists_map_pools')->truncate();
        DB::table('tourney_lists')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        /**
         * Get and Insert data
         */
        DB::connection('mysql3')->table('lis_tourney')
            ->chunkById(50, function ($repsTournamentsList) {
                try {
                    foreach ($repsTournamentsList as $item) {
                        if ( ! empty($item->maps)) {
                            $mapArrayVal = TourneyService::mapValForSeeder(trim($item->maps));
                        }

                        $insertItems[] = [
                            'id'              => $item->id,
                            'user_id'         => null,
                            'name'            => (string) $item->name,
                            'place'           => (string) $item->place,
                            'prize_pool'      => (string) $item->prize_pool,
                            'rules_link'      => (string) $item->rules_link,
                            'vod_link'        => (string) $item->vod_link,
                            'logo_link'       => (string) $item->logo_link,
                            'password'        => (string) $item->password,
                            'maps'            => (string) $item->maps,
                            'status'          => array_search(trim($item->state), TourneyList::$status),
                            'map_select_type' => array_search(trim($item->map_selecttype), TourneyList::$map_types),
                            'importance'      => (int) $item->importance,
                            'visible'         => $item->visible == 'VISIBLE' ? 1 : 0,
                            'ranking'         => $item->is_ranking == 'YES' ? 1 : 0,
                            'checkin_time'    => date('Y-m-d H:i:s', $item->time_checkin),
                            'start_time'      => date('Y-m-d H:i:s', $item->time_start),
                            'created_at'      => date('Y-m-d H:i:s', $item->time_reg),
                            'updated_at'      => date('Y-m-d H:i:s', $item->time_reg),
                        ];

                        if ( ! empty($mapArrayVal)) {
                            foreach ($mapArrayVal as $key => $mapId) {
                                $insert2Items[] = [
                                    'tourney_id' => $item->id,
                                    'map_id'     => $mapId,
                                ];
                            }
                        }
                    }
                    DB::table('tourney_lists')->insert($insertItems);
                    DB::table('tourney_lists_map_pools')->insert($insert2Items);
                } catch (\Exception $e) {
                    dd($e, $item);
                }
            });
    }

}
