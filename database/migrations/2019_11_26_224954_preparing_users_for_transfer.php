<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class PreparingUsersForTransfer extends Migration
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

        Schema::table('users', function (Blueprint $table) {
            Schema::disableForeignKeyConstraints();
        });
        /**
         * Drop forKeys
         */
        Schema::table('users', function (Blueprint $table) {
            $foreignKeys = $this->listTableForeignKeys('users');
            in_array('users_country_id_foreign', $foreignKeys) === true
                ? $table->dropForeign('users_country_id_foreign') : null;
            in_array('users_race_id_foreign', $foreignKeys) === true
                ? $table->dropForeign('users_race_id_foreign') : null;
            in_array('users_role_id_foreign', $foreignKeys) === true
                ? $table->dropForeign('users_role_id_foreign') : null;
        });
        /**
         * Add NewForKeys and columns
         */
        Schema::table('users', function (Blueprint $table) {

            $table->unsignedBigInteger('country_id')->nullable()->change();
            $table->unsignedBigInteger('race_id')->nullable()->change();
            $table->unsignedBigInteger('role_id')->nullable()->change();
            $table->foreign('country_id')->references('id')->on('countries')
                ->onDelete('SET NULL');
            $table->foreign('race_id')->references('id')->on('races')
                ->onDelete('SET NULL');
            $table->foreign('role_id')->references('id')->on('roles')
                ->onDelete('SET NULL');
        });
        /**
         * Enable forKeys
         */
        Schema::table('users', function (Blueprint $table) {
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

        return array_map(function ($key) {
            return $key->getName();
        }, $conn->listTableForeignKeys($table));
    }

}
