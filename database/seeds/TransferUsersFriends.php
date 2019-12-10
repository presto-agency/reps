<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Seeder;

class TransferUsersFriends extends Seeder
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
        Schema::table('user_friends', function (Blueprint $table) {
            Schema::disableForeignKeyConstraints();
        });
        /**
         * Clear table
         */
        DB::table('user_friends')->delete();
        /**
         * Get and Insert data
         */
        DB::connection("mysql2")->table("user_friends")
            ->chunkById(100, function ($repsUsersFriends) {
                try {
                    $insertItems = [];
                    foreach ($repsUsersFriends as $item) {
                        $insertItems[] = [
                            'id'             => $item->id,
                            'user_id'        => $item->user_id,
                            'friend_user_id' => $item->friend_user_id,
                            'created_at'     => $item->created_at,
                            'updated_at'     => $item->updated_at,
                            'deleted_at'     => $item->deleted_at,
                        ];
                    }
                    DB::table("user_friends")->insertOrIgnore($insertItems);
                } catch (\Exception $e) {
                    dd($e, $item);
                }
            });
        /**
         * Enable forKeys
         */
        Schema::table('user_friends', function (Blueprint $table) {
            Schema::enableForeignKeyConstraints();
        });
    }
}
