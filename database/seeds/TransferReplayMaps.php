<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class TransferReplayMaps extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /**
         * Disable forKeys
         */

        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        /**
         * Clear table
         */
        DB::table('replay_maps')->truncate();
        /**
         * Get and Insert data
         */
        DB::connection('mysql2')->table('replay_maps')
            ->chunkById(100, function ($repsReplayMap) {
                try {
                    $insertItems = [];
                    foreach ($repsReplayMap as $item) {
                        $url           = $this->checkUrl($item->url);
                        $insertItems[] = [
                            'id'         => $item->id,
                            'name'       => (string) trim($item->name),
                            'url'        => (string) $url,
                            'created_at' => Carbon::now(),
                        ];
                    }

                    DB::table('replay_maps')->insert($insertItems);
                } catch (\Exception $e) {
                    dd($e, $item);
                }
            }
            );
        /**
         * Enable forKeys
         */
        DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }

    public function checkUrl($url)
    {
        if (strpos($url, 'storage') == false) {
            if ($url[0] == '/') {
                return '/storage'.$url;
            } else {
                return '/storage/'.$url;
            }
        }

        return $url;
    }

}
