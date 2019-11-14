<?php

use App\Models\Replay;
use App\Models\ReplayMap;
use App\User;
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
        $repsReplays = DB::connection('mysql2')->table("replays")->get();

        foreach ($repsReplays as $item) {
            $userId = User::where('id', $item->user_id)->value('id');
            $mapId = ReplayMap::where('id', $item->map_id)->value('id');
            $firstCountryId = ReplayMap::where('id', $item->first_country_id)->value('id');
            $secondCountryId = ReplayMap::where('id', $item->second_country_id)->value('id');
            $firstRaceId = ReplayMap::where('id', $item->first_race)->value('id');
            $secondRaceId = ReplayMap::where('id', $item->second_race)->value('id');
            $typeId = ReplayMap::where('id', $item->type_id)->value('id');
            $file = DB::connection("mysql2")->table("files")->where('id', $item->file_id)->value('link');

            try {
                $insertItem = [
                    'user_id'           => !empty($userId) === true ? $userId : 1,
                    'map_id'            => !empty($mapId) === true ? $mapId : 1,
                    'first_country_id'  => !empty($firstCountryId) === true ? $firstCountryId : 1,
                    'second_country_id' => !empty($secondCountryId) === true ? $secondCountryId : 1,
                    'first_race'        => !empty($firstRaceId) === true ? $firstRaceId : 1,
                    'second_race'       => !empty($secondRaceId) === true ? $secondRaceId : 1,
                    'type_id'           => !empty($typeId) === true ? $typeId : 1,
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
                    'start_date'        => $item->start_date
                ];
                Replay::create($insertItem);

            } catch (\Exception $e) {
                dd($e, $insertItem);
            }
        }
    }
}
