<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Seeder;

class TransferUserReputations extends Seeder
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
        Schema::table('user_reputations', function (Blueprint $table) {
            Schema::disableForeignKeyConstraints();
        });
        /**
         * Clear table
         */
        DB::table('user_reputations')->delete();
        /**
         * Get and Insert data
         */
        DB::connection("mysql2")->table("user_reputations")
            ->chunkById(100, function ($repsUserReputations) {
                try {
                    $insertItems = [];
                    foreach ($repsUserReputations as $item) {
                        $insertItems[] = [
                            'id'           => $item->id,
                            'sender_id'    => $item->sender_id,
                            'recipient_id' => $item->recipient_id,
                            'object_id'    => $item->object_id,
                            'relation'     => $item->relation,
                            'comment'      => $item->comment,
                            'rating'       => $item->rating,
                            'created_at'   => $item->created_at,
                            'updated_at'   => $item->updated_at,
                        ];
                    }
                    DB::table("user_reputations")->insertOrIgnore($insertItems);
                } catch (\Exception $e) {
                    dd($e, $item);
                }
            });
        /**
         * Enable forKeys
         */
        Schema::table('user_reputations', function (Blueprint $table) {
            Schema::enableForeignKeyConstraints();
        });
    }

}
