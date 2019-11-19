<?php

use App\Models\ForumTopic;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Seeder;

class TransferForumTopics extends Seeder
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
        Schema::table('forum_topics', function (Blueprint $table) {
            Schema::disableForeignKeyConstraints();
        });
        /**
         * Drop forKeys
         */
        Schema::table('forum_topics', function (Blueprint $table) {
            $foreignKeys = $this->listTableForeignKeys('forum_topics');
            in_array('forum_topics_forum_section_id_foreign', $foreignKeys) === true ? $table->dropForeign('forum_topics_forum_section_id_foreign') : null;
            in_array('forum_topics_user_id_foreign', $foreignKeys) === true ? $table->dropForeign('forum_topics_user_id_foreign') : null;
        });
        /**
         * Clear table
         */
//        ForumTopic::query()->whereNotNull('id')->delete();
        /**
         * Remove autoIncr
         */
        Schema::table('forum_topics', function (Blueprint $table) {
            $table->unsignedBigInteger('id', false)->change();
            $table->longText('preview_content')->change();
        });
        /**
         * Get and Insert data
         */
        DB::connection("mysql2")->table("forum_topics")->orderBy('id','ASC')
            ->chunkById(100, function ($repsForumTopics) {
                try {
                    $insertItems = [];
                    foreach ($repsForumTopics as $item) {
                        $previewImg = DB::connection("mysql2")->table("files")->where('id', $item->preview_file_id)->value('link');
                        $insertItems[] = [
                            'id'               => $item->id,
                            'title'            => $item->title,
                            'forum_section_id' => $item->section_id,
                            'user_id'          => $item->user_id,
                            'reviews'          => $item->reviews,
                            'rating'           => $item->rating,
                            'preview_content'  => !empty($item->preview_content) === true ? $item->preview_content : '',
                            'preview_img'      => !empty($previewImg) === true ? $previewImg : '',
                            'content'          => !empty($item->content) === true ? $item->content : '',
                            'news'             => $item->news,
                            'start_on'         => !empty($item->start_on) === true ? $item->start_on : null,
                            'approved'         => $item->approved,
                            'negative_count'   => $item->negative_count,
                            'positive_count'   => $item->positive_count,
                            'updated_by_user'  => $item->updated_by_user,
                            'commented_at'     => $item->commented_at,
                            'created_at'       => $item->created_at,
                            'updated_at'       => $item->updated_at,
                        ];
                    }
                    DB::table("forum_topics")->insertOrIgnore($insertItems);
                } catch (\Exception $e) {
                    dd($e, $item);
                }
            });
        /**
         * Add autoIncr
         */
        Schema::table('forum_topics', function (Blueprint $table) {
            $table->unsignedBigInteger('id', true)->change();
        });
        /**
         * Add NewForKeys and columns
         */
        Schema::table('forum_topics', function (Blueprint $table) {

            $table->unsignedBigInteger('forum_section_id')->nullable()->change();
            $table->unsignedBigInteger('user_id')->nullable()->change();

            $table->foreign('forum_section_id')->references('id')->on('forum_sections')->onDelete('SET NULL');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('SET NULL');
        });
        /**
         * Enable forKeys
         */
        Schema::table('forum_topics', function (Blueprint $table) {
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
