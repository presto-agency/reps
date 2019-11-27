<?php

use App\Models\ReplayMap;
use Carbon\Carbon;
use Illuminate\Database\Schema\Blueprint;
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
        Schema::table('replay_maps', function (Blueprint $table) {
            Schema::disableForeignKeyConstraints();
        });

        /**
         * Clear table
         */
        DB::table('replay_maps')->delete();
        /**
         * Get and Insert data
         */
        DB::connection("mysql2")->table("replay_maps")
            ->chunkById(
                100, function ($repsReplayMap) {
                try {
                    $insertItems = [];
                    foreach ($repsReplayMap as $item) {
                        $url           = $this->checkUrl($item->url);
                        $insertItems[] = [
                            'id'         => $item->id,
                            'name'       => $item->name,
                            'url'        => $url,
                            'created_at' => Carbon::now(),
                        ];

                    }

                    DB::table("replay_maps")->insertOrIgnore($insertItems);
                } catch (\Exception $e) {
                    dd($e, $item);
                }
            }
            );
        /**
         * Enable forKeys
         */
        Schema::table('replay_maps', function (Blueprint $table) {
            Schema::enableForeignKeyConstraints();
        });
    }

    public function checkUrl($url)
    {
        if (strpos($url, 'storage') == false) {
            if ($url[0] == '/') {
                return "/storage".$url;
            } else {
                return "/storage/".$url;
            }
        }

        return $url;
    }

}
