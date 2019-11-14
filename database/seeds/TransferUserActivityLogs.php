<?php

use App\Models\UserActivityLog;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Seeder;

class TransferUserActivityLogs extends Seeder
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
        Schema::table('users', function (Blueprint $table) {
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
            $table->dropColumn('type_id');
            $table->dropColumn('parameters');

        });
        Schema::table('user_activity_logs', function (Blueprint $table) {
            $table->string('type');
            $table->json('parameters')->nullable();
        });
        /**
         * Clear table
         */
        UserActivityLog::query()->whereNotNull('id')->delete();
        /**
         * Remove autoIncr
         */
        Schema::table('user_activity_logs', function (Blueprint $table) {
            $table->unsignedBigInteger('id', false)->change();
        });
        /**
         * Get and Insert data
         */
        $repsUserActivityLogs = DB::connection('mysql2')->table("user_activity_logs")->get();
        foreach ($repsUserActivityLogs as $item) {
            try {
                $insertItem = [
                    'id'         => $item->id,
                    'type'       => $item->type,
                    'time'       => $item->time,
                    'user_id'    => $item->user_id,
                    'parameters' => $item->parameters,
                    'ip'         => $item->ip,
                    'created_at' => $item->created_at,
                    'updated_at' => $item->updated_at,
                ];

                DB::table("user_activity_logs")->insert($insertItem);

            } catch (\Exception $e) {
                dd($e, $item);
            }
        }

        /**
         * Add autoIncr
         */
        Schema::table('user_activity_logs', function (Blueprint $table) {
            $table->unsignedBigInteger('id', true)->change();
        });
        Schema::table('user_activity_logs', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->nullable()->change();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('SET NULL');
        });
        /**
         * Enable forKeys
         */
        Schema::table('users', function (Blueprint $table) {
            Schema::enableForeignKeyConstraints();
        });
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
