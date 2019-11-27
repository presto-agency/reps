<?php

use App\Models\UserActivityLog;
use Carbon\Carbon;
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
        Schema::table('user_activity_logs', function (Blueprint $table) {
            Schema::disableForeignKeyConstraints();
        });
        /**
         * Clear table
         */
        DB::table('user_activity_logs')->delete();
        /**
         * Get and Insert data
         */
        DB::connection("mysql2")->table("user_activity_logs")
            ->chunkById(100, function ($repsUserActivityLogs) {
                try {
                    $insertItems = [];
                    foreach ($repsUserActivityLogs as $item) {
                        $insertItems[] = [
                            'id'         => $item->id,
                            'type'       => $item->type,
                            'time'       => $item->time,
                            'user_id'    => $item->user_id,
                            'parameters' => $item->parameters,
                            'ip'         => $item->ip,
                            'created_at' => Carbon::now(),
                        ];

                    }
                    DB::table("user_activity_logs")->insertOrIgnore($insertItems);
                } catch (\Exception $e) {
                    dd($e, $item);
                }
            });

        /**
         * Enable forKeys
         */
        Schema::table('user_activity_logs', function (Blueprint $table) {
            Schema::enableForeignKeyConstraints();
        });
    }


}
