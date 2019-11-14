<?php

use App\Models\TourneyList;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Seeder;

class TransferTournamentsList extends Seeder
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
        TourneyList::query()->whereNotNull('id')->delete();
        /**
         * Remove autoIncr
         */
        Schema::table('tourney_lists', function (Blueprint $table) {
            $table->unsignedBigInteger('id', false)->change();
        });
        /**
         * Get and Insert data
         */
        $repsTournamentsList = DB::connection("mysql2")->table("tourney_lists")->get();
        foreach ($repsTournamentsList as $item) {
            try {
                $insertItem = [
                    'id'             => $item->id,
                    'tourney_id'     => $item->tourney_id,
                    'admin_id'       => $item->admin_id,
                    'name'           => $item->name,
                    'place'          => $item->place,
                    'prize_pool'     => $item->prize_pool,
                    'status'         => $item->status,
                    'visible'        => $item->visible,
                    'maps'           => $item->maps,
                    'rules_link'     => $item->rules_link,
                    'vod_link'       => $item->vod_link,
                    'logo_link'      => $item->logo_link,
                    'map_selecttype' => $item->map_selecttype,
                    'importance'     => $item->importance,
                    'is_ranking'     => $item->is_ranking,
                    'password'       => $item->password,
                    'checkin_time'   => $item->checkin_time,
                    'start_time'     => $item->start_time,
                    'created_at'     => $item->created_at,
                    'updated_at'     => $item->updated_at,
                ];

                DB::table("tourney_lists")->insert($insertItem);
            } catch (\Exception $e) {
                dd($e, $item);
            }
        }
        /**
         * Add autoIncr
         */
        Schema::table('tourney_lists', function (Blueprint $table) {
            $table->unsignedBigInteger('id', true)->change();
        });
    }
}
