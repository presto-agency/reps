<?php

use App\Models\ReplayMap;
use Illuminate\Database\Seeder;

class ReplayMapsTransfer extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run()
    {
        $repsReplayMap = DB::connection("mysql2")->table("replay_maps")->select('*')->get();
        foreach ($repsReplayMap as $item) {
            try {
                $insertItem = [
                    'name' => $item->name,
                    'url' => $item->url,
                ];
                ReplayMap::create($insertItem);
            } catch (\Exception $e) {
                dd($e, $item);
            }
        }
    }
}
