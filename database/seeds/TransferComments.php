<?php

use App\Models\Comment;
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
         * Drop forKeys
         */
        Schema::table('comments', function (Blueprint $table) {
            $foreignKeys = $this->listTableForeignKeys('comments');
            in_array('comments_user_id_foreign', $foreignKeys) === true ? $table->dropForeign('comments_user_id_foreign') : null;
        });
        /**
         * Clear table
         */
        Comment::query()->delete();
        /**
         * Remove autoIncr
         */
//        Schema::table('comments', function (Blueprint $table) {
//            $table->unsignedBigInteger('id', false)->change();
//        });
        /**
         * Get and Insert data
         */
        DB::connection("mysql2")->table("comments")
            ->chunkById(1000, function ($repsComments) {
                try {
                    $insertItems = [];
                    foreach ($repsComments as $item) {
                        $models = [
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
         * Add autoIncr
         */
//        Schema::table('comments', function (Blueprint $table) {
//            $table->unsignedBigInteger('id', true)->change();
//        });
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
