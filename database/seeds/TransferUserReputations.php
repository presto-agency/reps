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
         * Clear table
         */
        \App\Models\UserReputation::query()->whereNotNull('id')->delete();
        /**
         * Remove autoIncr
         */
        Schema::table('user_reputations', function (Blueprint $table) {
            $table->unsignedBigInteger('id', false)->change();
        });
        /**
         * Get and Insert data
         */
        DB::connection("mysql2")->table("user_reputations")->orderBy('id', 'ASC')
            ->chunkById(100, function ($repsUserReputations) {
                try {
                    $insertItems = [];
                    foreach ($repsUserReputations as $item) {
                        $insertItems[] = [
                            'id'         => $item->id,
                            'sender_id'   => $item->sender_id,
                            'recipient_id'     => $item->recipient_id,
                            'object_id'  => $item->object_id,
                            'relation'  => $item->relation,
                            'comment'  => $item->comment,
                            'rating'  => $item->rating,
                            'created_at' => $item->created_at,
                            'updated_at' => $item->updated_at,
                        ];
                    }
                    DB::table("user_reputations")->insertOrIgnore($insertItems);
                } catch (\Exception $e) {
                    dd($e, $item);
                }
            });
        /**
         * Add autoIncr
         */
        Schema::table('user_reputations', function (Blueprint $table) {
            $table->unsignedBigInteger('id', true)->change();
        });
    }
}
