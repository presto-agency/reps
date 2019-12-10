<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class PreparingReplaysForTransfer extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        /**
         * Disable forKeys
         */
        Schema::table('replays', function (Blueprint $table) {
            Schema::disableForeignKeyConstraints();
        });
        /**
         * Drop forKeys
         */
        Schema::table('replays', function (Blueprint $table) {
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
        });

        /**
         * Add NewForKeys and columns
         */
        Schema::table('replays', function (Blueprint $table) {

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
                ->onDelete('SET NULL');});
        /**
         * Enable forKeys
         */
        Schema::table('replays', function (Blueprint $table) {
            Schema::enableForeignKeyConstraints();
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
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
}
