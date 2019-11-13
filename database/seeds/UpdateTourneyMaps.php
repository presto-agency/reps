<?php

use App\Models\ReplayMap;
use App\Services\ServiceAssistants\PathHelper;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UpdateTourneyMaps extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tourneys = DB::table('tourney_lists')->get(['id','maps']);
        foreach ($tourneys as $item) {
            if (trim($item->maps) != '') {

                $maps = explode(",", $item->maps);
                $regMapIDs = array();
                foreach ($maps as $m) {
                    $map = trim($m);

                    $checkMapId = DB::table('replay_maps')->where('name', $map)->value('id');
                    if (!$checkMapId) {
                        $createMap = ReplayMap::create([
                            'name' => $map,
                            'url' =>  PathHelper::checkUploadStoragePath("/image/replay/map") . $map . '.jpg'
                        ]);
                        $regMapIDs[] = $checkMapId;
                    } else {
                        $regMapIDs[] = $checkMapId;
                        continue;
                    }

                }
                if (!empty($regMapIDs)) {
                    DB::table('tourney_lists')
                        ->where('id', $item->id)
                        ->update(['maps' => implode(",", $regMapIDs)]);
                }
            }
        }
    }
}
