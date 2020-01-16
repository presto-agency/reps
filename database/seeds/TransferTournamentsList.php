<?php

use App\Models\ReplayMap;
use App\Models\TourneyList;
use Carbon\Carbon;
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
        DB::table('tourney_lists')->truncate();


        /**
         * Get and Insert data
         */
        DB::connection('mysql3')->table('lis_tourney')
            ->chunkById(50, function ($repsTournamentsList) {
                try {
                    foreach ($repsTournamentsList as $item) {
                        if ( ! empty($item->maps)) {
                            $this->checkMaps($item->maps);
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
                            'reg_time'        => Carbon::parse($item->time_reg)->format('Y-m-d H:i:s'),
                            'checkin_time'    => Carbon::parse($item->time_checkin)->format('Y-m-d H:i:s'),
                            'start_time'      => Carbon::parse($item->time_start)->format('Y-m-d H:i:s'),
                        ];
                    }

                    DB::table('tourney_lists')->insert($insertItems);
                } catch (\Exception $e) {
                    dd($e, $item);
                }
            });
        DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }


    /**
     * Check maps if not exists create then add in mapsPoll
     *
     * @param $maps
     */
    public function checkMaps($maps)
    {
        $data = null;

        foreach (explode(',', $maps) as $mapName) {
            $checkMap = ReplayMap::query()->where('name', 'like', '%'.trim($mapName).'%')->value('id');
            if (empty($checkMap)) {
                $dataCC     = Storage::disk('public')->allFiles('maps/cc');
                $dataJPG256 = Storage::disk('public')->allFiles('maps/jpg256');
                $dataSC     = Storage::disk('public')->allFiles('maps/sc');
                $dataWC     = Storage::disk('public')->allFiles('maps/wc');

                $url = null;
                if (in_array('maps/cc/'.trim($mapName).'.jpg', $dataCC)) {
                    $url = '/storage/maps/cc/'.trim($mapName).'.jpg';
                }
                if (in_array('maps/jpg256/'.trim($mapName).'.jpg', $dataJPG256)) {
                    $url = '/storage/maps/jpg256/'.trim($mapName).'.jpg';
                }
                if (in_array('maps/sc/'.trim($mapName).'.jpg', $dataSC)) {
                    $url = '/storage/maps/sc/'.trim($mapName).'.jpg';
                }
                if (in_array('maps/wc/'.trim($mapName).'.jpg', $dataWC)) {
                    $url = '/storage/maps/wc/'.trim($mapName).'.jpg';
                }

                $data[] = [
                    'name' => trim($mapName),
                    'url'  => $url,
                ];
            }
        }

        $data = collect($data);
        if (isset($data) && $data->isNotEmpty()) {
            ReplayMap::query()->insert($data->toArray());
        }
    }

}
