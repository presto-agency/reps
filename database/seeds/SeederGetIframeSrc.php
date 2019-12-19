<?php

use App\Models\Replay;
use Illuminate\Database\Seeder;

class SeederGetIframeSrc extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $getData = Replay::whereNotNull('video_iframe')->get(['id', 'video_iframe']);

        foreach ($getData as $item) {
            try {
                $newData             = Replay::select(['id', 'src_iframe', 'video_iframe'])->find($item->id);
                $newData->src_iframe = self::getIframeSrc($newData->video_iframe);
                $newData->save();
            } catch (Exception $e) {
                dd($e, $newData);
            }
        }
    }

    public static function getIframeSrc($iframe_string)
    {
        $checkIframe = strpos($iframe_string, '<iframe');
        if ($checkIframe !== false) {
            preg_match('/src="([^"]+)"/', $iframe_string, $match);

            return $match[1];
        } else {
            return null;
        }
    }

}
