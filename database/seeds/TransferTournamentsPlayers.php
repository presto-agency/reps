<?php

use App\Models\TourneyPlayer;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Seeder;

class TransferTournamentsPlayers extends Seeder
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
        TourneyPlayer::query()->delete();
        /**
         * Remove autoIncr
         */
//        Schema::table('tourney_players', function (Blueprint $table) {
//            $table->unsignedBigInteger('id', false)->change();
//        });
        /**
         * Get and Insert data
         */
        DB::connection("mysql2")->table("tourney_players")
            ->chunkById(100, function ($repsTournamentsPlayers) {
                try {
                    $insertItems = [];
                    foreach ($repsTournamentsPlayers as $item) {
                        $insertItems[] = [
                            'id'                => $item->id,
                            'defiler_player_id' => $item->defiler_player_id,
                            'tourney_id'        => $item->tourney_id,
                            'user_id'           => $item->user_id,
                            'check_in'          => $item->check_in,
                            'description'       => $item->description,
                            'place_result'      => $item->place_result,
                            'created_at'        => $item->created_at,
                            'updated_at'        => $item->updated_at,
                        ];

                    }
                    DB::table("tourney_players")->insertOrIgnore($insertItems);
                } catch (\Exception $e) {
                    dd($e, $item);
                }
            });
        /**
         * Add autoIncr
         */
//        Schema::table('tourney_players', function (Blueprint $table) {
//            $table->unsignedBigInteger('id', true)->change();
//        });
    }
}
