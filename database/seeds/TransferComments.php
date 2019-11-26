<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Seeder;

class TransferComments extends Seeder
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
        Schema::table('comments', function (Blueprint $table) {
            Schema::disableForeignKeyConstraints();
        });

        /**
         * Clear table
         */
        DB::table('comments')->delete();
        /**
         * Get and Insert data
         */
        DB::connection("mysql2")->table("comments")
            ->chunkById(500, function ($repsComments) {
                try {
                    $insertItems = [];
                    foreach ($repsComments as $item) {
                        $models        = [
                            1 => "App\Models\ForumTopic",
                            2 => "App\Models\Replay",
                            3 => "App\Models\UserGallery",
                        ];
                        $insertItems[] = [
                            'id'               => $item->id,
                            'user_id'          => $item->user_id,
                            'commentable_id'   => $item->object_id,
                            'commentable_type' => $models[$item->relation],
                            'title'            => $item->title,
                            'content'          => $item->content,
                            'created_at'       => $item->created_at,
                            'updated_at'       => $item->updated_at,
                        ];

                    }
                    DB::table("comments")->insertOrIgnore($insertItems);
                } catch (\Exception $e) {
                    dd($e, $item);
                }
            });

        /**
         * Enable forKeys
         */
        Schema::table('comments', function (Blueprint $table) {
            Schema::enableForeignKeyConstraints();
        });
    }

}
