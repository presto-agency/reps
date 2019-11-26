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
        Schema::table(
            'replays', function (Blueprint $table) {
            Schema::disableForeignKeyConstraints();
        }
        );
        Schema::table(
            'replay_maps', function (Blueprint $table) {
            Schema::disableForeignKeyConstraints();
        }
        );
        /**
         * Drop forKeys
         */
        Schema::table(
            'replays', function (Blueprint $table) {
            $foreignKeys = $this->listTableForeignKeys('replays');
            in_array('replays_user_id_foreign', $foreignKeys) === true
                ? $table->dropForeign('replays_user_id_foreign') : null;
            in_array('replays_map_id_foreign', $foreignKeys) === true
                ? $table->dropForeign('replays_map_id_foreign') : null;
            in_array('replays_first_country_id_foreign', $foreignKeys) === true
                ? $table->dropForeign('replays_first_country_id_foreign')
                : null;
            in_array('replays_second_country_id_foreign', $foreignKeys) === true
                ? $table->dropForeign('replays_second_country_id_foreign')
                : null;
            in_array('replays_first_race_foreign', $foreignKeys) === true
                ? $table->dropForeign('replays_first_race_foreign') : null;
            in_array('replays_second_race_foreign', $foreignKeys) === true
                ? $table->dropForeign('replays_second_race_foreign') : null;
            in_array('replays_type_id_foreign', $foreignKeys) === true
                ? $table->dropForeign('replays_type_id_foreign') : null;
        }
        );
        /**
         * Clear table
         */
        ReplayMap::query()->delete();
        /**
         * Remove autoIncr
         */
        //        Schema::table(
        //            'replay_maps', function (Blueprint $table) {
        //            $table->unsignedBigInteger('id', false)->change();
        //        }
        //        );
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
                }
            }
            );
        /**
         * Add autoIncr
         */
        //        Schema::table(
        //            'replay_maps', function (Blueprint $table) {
        //            $table->unsignedBigInteger('id', true)->change();
        //        }
        //        );
        /**
         * Add NewForKeys and columns
         */
        Schema::table(
            'replays', function (Blueprint $table) {

            $table->unsignedBigInteger('user_id')->nullable()->change();
            $table->unsignedBigInteger('map_id')->nullable()->change();
            $table->unsignedBigInteger('first_country_id')->nullable()
                ->change();
            $table->unsignedBigInteger('second_country_id')->nullable()
                ->change();
            $table->unsignedBigInteger('first_race')->nullable()->change();
            $table->unsignedBigInteger('second_race')->nullable()->change();
            $table->unsignedBigInteger('type_id')->nullable()->change();

            $table->foreign('user_id')->references('id')->on('users')->onDelete(
                'SET NULL'
            );
            $table->foreign('map_id')->references('id')->on('replay_maps')
                ->onDelete('SET NULL');
            $table->foreign('first_country_id')->references('id')->on(
                'countries'
            )->onDelete('SET NULL');
            $table->foreign('second_country_id')->references('id')->on(
                'countries'
            )->onDelete('SET NULL');
            $table->foreign('first_race')->references('id')->on('races')
                ->onDelete('SET NULL');
            $table->foreign('second_race')->references('id')->on('races')
                ->onDelete('SET NULL');
            $table->foreign('type_id')->references('id')->on('replay_types')
                ->onDelete('SET NULL');
        }
        );
        /**
         * Enable forKeys
         */
        Schema::table(
            'replays', function (Blueprint $table) {
            Schema::enableForeignKeyConstraints();
        }
        );
        Schema::table(
            'replay_maps', function (Blueprint $table) {
            Schema::enableForeignKeyConstraints();
        }
        );
    }

    /**
     * @param $table
     *
     * @return array
     */
    public function listTableForeignKeys($table)
    {
        $conn = Schema::getConnection()->getDoctrineSchemaManager();

        return array_map(
            function ($key) {
                return $key->getName();
            }, $conn->listTableForeignKeys($table)
        );
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
