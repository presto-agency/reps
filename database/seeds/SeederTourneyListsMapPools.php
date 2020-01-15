<?php

use App\Models\ReplayMap;
use Illuminate\Database\Seeder;

class SeederTourneyListsMapPools extends Seeder
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
        DB::statement('SET FOREIGN_KEY_CHECKS=1');


        /**
         * Get and Insert data
         */
        DB::table('tourney_lists')->select('id', 'maps')->whereNotNull('maps')
            ->where('maps', '!=', '')->orderBy('id')
            ->chunk(50, function ($tourneyLists) {
                try {
                    foreach ($tourneyLists as $item) {
                        $insertItems = null;
                        foreach (explode(',', $item->maps) as $mapName) {
                            $checkMap      = ReplayMap::query()->where('name', 'like', '%'.trim($mapName).'%')->value('id');
                            $insertItems[] = [
                                'tourney_id' => $item->id,
                                'map_id'     => $checkMap,
                            ];
                        }
                        DB::table('tourney_lists_map_pools')->insert($insertItems);
                    }

                } catch (\Exception $e) {
                    dd($e, $item);
                }
            });
    }

}
