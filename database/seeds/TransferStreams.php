<?php


use App\Models\Race;
use App\Models\Stream;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Seeder;

class TransferStreams extends Seeder
{
    public function run()
    {
        /**
         * Disable forKeys
         */
        Schema::table('streams', function (Blueprint $table) {
            Schema::disableForeignKeyConstraints();
        });
        /**
         * Clear table
         */
        DB::table('streams')->delete();
        /**
         * Get and Insert data
         */
        DB::connection("mysql2")->table("streams")
            ->chunkById(100, function ($repsStreams) {
                try {
                    $insertItems = [];
                    foreach ($repsStreams as $item) {
                        $insertItems[] = [
                            'id'                => $item->id,
                            'user_id'           => $item->user_id,
                            'title'             => $item->title,
                            'race_id'           => Race::where('code', $item->race)->value('id'),
                            'content'           => $item->content,
                            'country_id'        => $item->country_id,
                            'stream_url'        => null,
                            'stream_url_iframe' => null,
                            'active'            => $item->active,
                            'approved'          => $item->approved,
                            'created_at'        => $item->created_at,
                            'updated_at'        => $item->updated_at,
                        ];
                    }
                    DB::table("streams")->insertOrIgnore($insertItems);
                } catch (\Exception $e) {
                    dd($e, $item);
                }
            });
        /**
         * Enable forKeys
         */
        Schema::table('streams', function (Blueprint $table) {
            Schema::enableForeignKeyConstraints();
        });
    }


}
