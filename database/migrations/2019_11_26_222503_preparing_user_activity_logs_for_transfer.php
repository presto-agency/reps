<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class PreparingUserActivityLogsForTransfer extends Migration
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
        Schema::table('user_activity_logs', function (Blueprint $table) {
            Schema::disableForeignKeyConstraints();
        });
        /**
         * Drop forKeys
         */
        Schema::table('user_activity_logs', function (Blueprint $table) {
            $foreignKeys = $this->listTableForeignKeys('user_activity_logs');
            in_array('user_activity_logs_user_id_foreign', $foreignKeys) === true ? $table->dropForeign('user_activity_logs_user_id_foreign') : null;
            in_array('user_activity_logs_type_id_foreign', $foreignKeys) === true ? $table->dropForeign('user_activity_logs_type_id_foreign') : null;
        });
        /**
         * Change columns
         */
        Schema::table('user_activity_logs', function (Blueprint $table) {
            if (Schema::hasColumn('user_activity_logs', 'type_id')) {
                $table->dropColumn('type_id');
            }
            if (Schema::hasColumn('user_activity_logs', 'parameters')) {
                $table->dropColumn('parameters');
            }
        });
        Schema::table('user_activity_logs', function (Blueprint $table) {
            if (!Schema::hasColumn('user_activity_logs', 'type')) {
                $table->string('type');
            }
            if (!Schema::hasColumn('user_activity_logs', 'parameters')) {
                $table->json('parameters')->nullable();
            }
        });

        Schema::table('user_activity_logs', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->nullable()->change();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('SET NULL');
        });
        /**
         * Enable forKeys
         */
        Schema::table('user_activity_logs', function (Blueprint $table) {
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
