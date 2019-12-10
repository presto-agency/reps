<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class PreparingCommentsForTransfer extends Migration
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
        Schema::table('comments', function (Blueprint $table) {
            Schema::disableForeignKeyConstraints();
        });
        /**
         * Drop forKeys
         */
        Schema::table('comments', function (Blueprint $table) {
            $foreignKeys = $this->listTableForeignKeys('comments');
            in_array('comments_user_id_foreign', $foreignKeys) === true ? $table->dropForeign('comments_user_id_foreign') : null;
        });
        /**
         * Add NewForKeys and columns
         */
        Schema::table('comments', function (Blueprint $table) {

            $table->unsignedBigInteger('user_id')->nullable()->change();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('SET NULL');
        });
        /**
         * Enable forKeys
         */
        Schema::table('comments', function (Blueprint $table) {
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
