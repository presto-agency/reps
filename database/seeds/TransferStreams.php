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
         * Drop forKeys
         */
        Schema::table('streams', function (Blueprint $table) {
            $foreignKeys = $this->listTableForeignKeys('streams');
            in_array('streams_user_id_foreign', $foreignKeys) === true ? $table->dropForeign('streams_user_id_foreign') : null;
            in_array('streams_race_id_foreign', $foreignKeys) === true ? $table->dropForeign('streams_race_id_foreign') : null;
            in_array('streams_country_id_foreign', $foreignKeys) === true ? $table->dropForeign('streams_country_id_foreign') : null;
        });
        /**
         * Clear table
         */
        Stream::query()->whereNotNull('id')->delete();
        /**
         * Remove autoIncr
         */
        Schema::table('streams', function (Blueprint $table) {
            $table->unsignedBigInteger('id', false)->change();
        });
        /**
         * Get and Insert data
         */
        $repsStreams = DB::connection('mysql2')->table("streams")->get();
        foreach ($repsStreams as $item) {
            $raceId = Race::where('code', $item->race)->value('id');
//            preg_match('/src="([^"]+)"/', $item->stream_url, $match);
//            $stream_url_iframe = $match[1];
            try {
                $insertItem = [
                    'id'                => $item->id,
                    'user_id'           => $item->user_id,
                    'title'             => $item->title,
                    'race_id'           => $raceId,
                    'content'           => $item->content,
                    'country_id'        => $item->country_id,
                    'stream_url'        => null,
                    'stream_url_iframe' => null,
                    'active'            => $item->active,
                    'approved'          => $item->approved,
                    'created_at'        => $item->created_at,
                    'updated_at'        => $item->updated_at,
                ];
                DB::table("streams")->insert($insertItem);

            } catch (\Exception $e) {
                dd($e, $item);
            }
        }
        /**
         * Add autoIncr
         */
        Schema::table('streams', function (Blueprint $table) {
            $table->unsignedBigInteger('id', true)->change();
        });
        /**
         * Add NewForKeys and columns
         */
        Schema::table('streams', function (Blueprint $table) {

            $table->unsignedBigInteger('user_id')->nullable()->change();
            $table->unsignedBigInteger('country_id')->nullable()->change();
            $table->unsignedBigInteger('race_id')->nullable()->change();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('SET NULL');
            $table->foreign('country_id')->references('id')->on('countries')->onDelete('SET NULL');
            $table->foreign('race_id')->references('id')->on('races')->onDelete('SET NULL');
        });
        /**
         * Enable forKeys
         */
        Schema::table('streams', function (Blueprint $table) {
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
