<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Seeder;

class TransferUserGalleries extends Seeder
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
        Schema::table('user_galleries', function (Blueprint $table) {
            Schema::disableForeignKeyConstraints();
        });
        /**
         * Clear table
         */
        DB::table('user_galleries')->delete();
        /**
         * Get and Insert data
         */
        DB::connection("mysql2")->table("user_galleries")
            ->chunkById(100, function ($repsReplays) {
                try {
                    $insertItems = [];
                    foreach ($repsReplays as $item) {
                        $file          = DB::connection("mysql2")
                            ->table("files")->where('id', $item->file_id)
                            ->value('link');
                        $insertItems[] = [
                            'id'             => $item->id,
                            'user_id'        => $item->user_id,
                            'picture'        => ! empty($file) === true ? $file
                                : '',
                            'sign'           => $item->comment,
                            'for_adults'     => $item->for_adults,
                            'rating'         => $item->rating,
                            'negative_count' => $item->negative_count,
                            'positive_count' => $item->positive_count,
                            'reviews'        => $item->reviews,
                            'deleted_at'     => $item->deleted_at,
                            'created_at'     => $item->created_at,
                            'updated_at'     => $item->updated_at,
                        ];
                    }
                    DB::table("user_galleries")->insertOrIgnore($insertItems);
                } catch (\Exception $e) {
                    dd($e, $item);
                }
            });
        /**
         * Enable forKeys
         */
        Schema::table('user_galleries', function (Blueprint $table) {
            Schema::enableForeignKeyConstraints();
        });
    }

}
