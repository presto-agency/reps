<?php

namespace App\Console\Commands\Broadcasting;

use App\Services\Broadcasting\{AfreecaTV, GoodGame, Twitch};
use DB;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class BroadcastCheck extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'broadcast:check';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Checking broadcast channels(streams) using services(Broadcasting)';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function handle()
    {
//        $getStreams = Stream::query()
//            /*->select(['stream_url', 'id', 'approved'])*/
//            ->where('approved', 1)
//            ->get();
        /**
         * Get and Insert data
         */
        try {

            DB::table("streams")->select(['stream_url', 'id', 'approved'])
                ->where('approved', 1)
                ->chunkById(100, function ($getStreams) {
                    $data = collect($getStreams);
//                Log::info('streams: ');
//                Log::info($data);
                    if ($data->isNotEmpty()) {
                        foreach ($data as $item) {
                            try {
                                if (!empty($item->stream_url)) {
                                    $getResult = $this->liveStreamCheck($item->stream_url, $item->id);
//                                Log::info('getResult: ');
//                                Log::info($getResult);
                                    DB::table("streams")->where('id', $item->id)
                                        ->update(['active' => self::getActive($getResult['status'])]);
                                } else {
                                    DB::table("streams")->where('id', $item->id)->update(['active' => false]);
                                }
                            } catch (Exception $e) {
                                Log::error($e->getMessage());
                            }
                        }
                    }
                });
        } catch (Exception $e) {
            Log::error($e->getMessage());
        }
    }

    /**
     * @param $data
     *
     * @return bool
     */
    private static function getActive($data): bool
    {
        $active = false;
        if ($data === config('streams.status')) {
            $active = true;
        }

        return $active;
    }

    /**
     * @param $stream_url
     * @param $id
     *
     * @return array|bool
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function liveStreamCheck($stream_url, $id)
    {
        $parts = $this->parse_stream_url($stream_url);
        $host = $parts['host'];

        if ($host == config('streams.goodgame.host')) {
            $chanelName = explode('/', $parts['path'])[2];

            return $this->goodGame($chanelName, $id);
        }
        if ($host == config('streams.twitch.host')) {
            $chanelName = explode('/', $parts['path'])[1];

            return $this->twitch($chanelName, $id);
        }
        if ($host == config('streams.afreecatv.host')) {
            $chanelName = explode("/", $parts['path'])[1];

            return $this->afreecaTv($chanelName, $id);
        }

        return false;
    }

    /**
     * @param $url
     *
     * @return mixed
     */
    public function parse_stream_url($url)
    {
        return parse_url(htmlspecialchars_decode($url));
    }

    /**
     * Exemple URL https://goodgame.ru/channel/erling-wd2/#autoplay
     *
     * @param $chanelName  = erling-wd2
     * @param $id
     *
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function goodGame($chanelName, $id)
    {
        $goodGame = new GoodGame();

        return $goodGame->getStatus($chanelName, $id);
    }

    /**
     * Exemple URL  https://www.twitch.tv/disguisedtoast
     *
     * @param $chanelName  = disguisedtoast
     * @param $id
     *
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function twitch($chanelName, $id)
    {
        $twitch = new Twitch();

        return $twitch->getStatus($chanelName, $id);
    }

    /**
     * Exemple URL  http://play.afreecatv.com/redinctv/218078580
     *
     * @param $chanelName  = redinctv
     * @param $id
     *
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function afreecaTv($chanelName, $id)
    {
        $afreecaTv = new AfreecaTV();

        return $afreecaTv->getStatus($chanelName, $id);
    }

}
