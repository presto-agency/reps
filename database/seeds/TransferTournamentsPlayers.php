<?php

use App\Models\TourneyPlayer;
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
        $repsTournamentsPlayers = DB::connection('mysql2')->table("tourney_players")->get();

        foreach ($repsTournamentsPlayers as $item) {
            try {
                $insertItem = [
                    'defiler_player_id' => $item->defiler_player_id,
                    'tourney_id'        => $item->tourney_id,
                    'user_id'           => $item->user_id,
                    'check_in'          => $item->check_in,
                    'description'       => $item->description,
                    'place_result'      => $item->place_result,
                ];
                TourneyPlayer::create($insertItem);
            } catch (\Exception $e) {
                dd($e, $insertItem);
            }
        }
    }
}
