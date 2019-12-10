<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class PreparingStreamsForTransfer extends Migration
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
        Schema::table('streams', function (Blueprint $table) {
            Schema::disableForeignKeyConstraints();
        });
        /**
         * Drop forKeys
         */
        Schema::table('streams', function (Blueprint $table) {
            $foreignKeys = $this->listTableForeignKeys('streams');
            in_array('streams_user_id_foreign', $foreignKeys) === true ? $table->dropForeign('streams_user_id_foreign') : null;
            in_array('streams_race_id_foreign', $foreignKeys) === true ? $table->dropForeign('streams_race_id_foreign') : null;
            in_array('streams_country_id_foreign', $foreignKeys) === true ? $table->dropForeign('streams_country_id_foreign') : null;
        });
        /**
         * Add NewForKeys and columns
         */
        Schema::table('streams', function (Blueprint $table) {

            $table->unsignedBigInteger('user_id')->nullable()->change();
            $table->unsignedBigInteger('country_id')->nullable()->change();
            $table->unsignedBigInteger('race_id')->nullable()->change();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('SET NULL');
            $table->foreign('country_id')->references('id')->on('countries')->onDelete('SET NULL');
            $table->foreign('race_id')->references('id')->on('races')->onDelete('SET NULL');
        });

        /**
         * Enable forKeys
         */
        Schema::table('streams', function (Blueprint $table) {
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
     * @return array
     */
    public function listTableForeignKeys($table)
    {
        $conn = Schema::getConnection()->getDoctrineSchemaManager();

        return array_map(function ($key) {
            return $key->getName();
        }, $conn->listTableForeignKeys($table));
    }
}
