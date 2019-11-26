<?php

use App\Models\Race;
use App\Models\Replay;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Seeder;

class TransferReplays extends Seeder
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
        Schema::table('replays', function (Blueprint $table) {
            Schema::disableForeignKeyConstraints();
        });
        /**
         * Clear table
         */
        DB::table('replays')->delete();
        /**
         * Get and Insert data
         */
        DB::connection("mysql2")->table("replays")
            ->chunkById(100, function ($repsReplays) {
                try {
                    $insertItems = [];
                    foreach ($repsReplays as $item) {
                        $file = DB::connection("mysql2")->table("files")->where('id', $item->file_id)->value('link');
                        $insertItems[] = [
                            'id'                => $item->id,
                            'user_id'           => $item->user_id,
                            'map_id'            => $item->map_id,
                            'first_country_id'  => $item->first_country_id,
                            'second_country_id' => $item->second_country_id,
                            'first_race'        => Race::where('code', $item->first_race)->value('id'),
                            'second_race'       => Race::where('code', $item->second_race)->value('id'),
                            'type_id'           => $item->type_id,
                            'file'              => !empty($file) === true ? $file : '',
                            'title'             => $item->title,
                            'video_iframe'      => $item->video_iframe,
                            'user_replay'       => $item->user_replay,
                            'user_rating'       => $item->user_rating,
                            'negative_count'    => $item->negative_count,
                            'rating'            => $item->rating,
                            'positive_count'    => $item->positive_count,
                            'approved'          => $item->approved,
                            'first_location'    => $item->first_location,
                            'first_name'        => $item->first_name,
                            'second_location'   => $item->second_location,
                            'second_name'       => $item->second_name,
                            'content'           => $item->content,
                            'downloaded'        => $item->downloaded,
                            'start_date'        => $item->start_date,
                            'created_at'        => $item->created_at,
                            'updated_at'        => $item->updated_at,
                        ];
                    }
                    DB::table("replays")->insertOrIgnore($insertItems);
                } catch (\Exception $e) {
                    dd($e, $item);
                }
            });
        /**
         * Enable forKeys
         */
        Schema::table('replays', function (Blueprint $table) {
            Schema::enableForeignKeyConstraints();
        });
    }
}
