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
         * Clear table
         */
        DB::table('forum_topics')->delete();
        /**
         * Get and Insert data
         */
        DB::connection("mysql2")->table("forum_topics")
            ->chunkById(200, function ($repsForumTopics) {
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
         * Enable forKeys
         */
        Schema::table('forum_topics', function (Blueprint $table) {
            Schema::enableForeignKeyConstraints();
        });
    }
}
