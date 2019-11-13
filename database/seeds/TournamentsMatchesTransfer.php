<?php

use App\Models\TourneyMatch;
use Illuminate\Database\Seeder;

class TournamentsMatchesTransfer extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $repsTournamentsMatches = DB::connection("mysql2")->table("tourney_matches")->select('*')
            ->get();
        foreach ($repsTournamentsMatches as $item) {
            $rep1 = DB::connection("mysql2")->table("files")->where('id', $item->rep1)->value('link');
            $rep2 = DB::connection("mysql2")->table("files")->where('id', $item->rep2)->value('link');
            $rep3 = DB::connection("mysql2")->table("files")->where('id', $item->rep3)->value('link');
            $rep4 = DB::connection("mysql2")->table("files")->where('id', $item->rep4)->value('link');
            $rep5 = DB::connection("mysql2")->table("files")->where('id', $item->rep5)->value('link');
            $rep6 = DB::connection("mysql2")->table("files")->where('id', $item->rep6)->value('link');
            $rep7 = DB::connection("mysql2")->table("files")->where('id', $item->rep7)->value('link');
            try {
                $insertItem = [
                    'tourney_id' => $item->tourney_id,
                    'match_id' => $item->match_id,
                    'round' => $item->round,
                    'round_id' => $item->round_id,
                    'player1_id' => $item->player1_id,
                    'player2_id' => $item->player2_id,
                    'player1_score' => $item->player1_score,
                    'player2_score' => $item->player2_score,
                    'win_score' => $item->win_score,
                    'winner_action' => $item->winner_action,
                    'winner_value' => $item->winner_value,
                    'looser_action' => $item->looser_action,
                    'looser_value' => $item->looser_value,
                    'played' => $item->played,
                    'rep1' => !empty($rep1) === true ? $rep1 : '',
                    'rep2' => !empty($rep2) === true ? $rep2 : '',
                    'rep3' => !empty($rep3) === true ? $rep3 : '',
                    'rep4' => !empty($rep4) === true ? $rep4 : '',
                    'rep5' => !empty($rep5) === true ? $rep5 : '',
                    'rep6' => !empty($rep6) === true ? $rep6 : '',
                    'rep7' => !empty($rep7) === true ? $rep7 : '',
                ];
                TourneyMatch::create($insertItem);
            } catch (\Exception $e) {
                dd($e, $insertItem);
            }

        }
    }
}
