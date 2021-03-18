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
     * Get and Insert data
     */
    public function handle()
    {
        DB::table('streams')->where('approved', 1)
            ->whereNotNull('channel')
            ->whereNotNull('resource')
            ->whereNotNull('stream_url')
            ->chunkById(100, function ($data) {
                try {
                    $activeIds = [];
                    $notActiveIds = [];
                    foreach ($data as $item) {
                        try {
                            if (!empty($item->channel) && !empty($item->resource) && !empty($item->stream_url)) {
                                $result = $this->liveStreamCheck2($item->channel, $item->resource, $item->id);
                                sleep(1);

                                if (!is_null($result) && self::getActive($result['status'])) {
                                    $activeIds[$item->id] = $item->id;
                                } else {
                                    $notActiveIds[$item->id] = $item->id;
                                }
                            } else {
                                $notActiveIds[$item->id] = $item->id;
                            }
                        } catch (Exception $e) {
                            continue;
                        }
                    }
                    if (!empty($activeIds)) {
                        DB::table('streams')->whereIn('id', $activeIds)->update(['active' => true]);
                    }
                    if (!empty($notActiveIds)) {
                        DB::table('streams')->whereIn('id', $notActiveIds)->update(['active' => false]);
                    }
                } catch (Exception $e) {
                    Log::error($e->getMessage());
                }
            });
    }

    /**
     * @param $channel
     * @param $resource
     * @param $id
     * @return array|null
     */
    public function liveStreamCheck2($channel, $resource, $id)
    {
        try {
            switch ($resource) {
                case config('streams.goodgame.host'):
                    return $this->goodGame($channel, $id);
                case config('streams.twitch.host'):
                    return $this->twitch($channel, $id);
                case config('streams.afreecatv.host'):
                    return $this->afreecaTv($channel, $id);
                default:
                    return null;
            }
        } catch (\GuzzleHttp\Exception\GuzzleException $e) {
            if ($e->status !== 401) {
                Log::error($e->getMessage());
            }
            return null;
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return null;
        }
    }

    /**
     * @param $status
     *
     * @return bool
     */
    private static function getActive($status): bool
    {
        if ($status === config('streams.status')) {
            return true;
        }

        return false;
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
     * @return array|null
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function twitch($chanelName, $id)
    {
        if (empty(config('streams.twitch.client_id'))) {
            Log::info('Stream .env miss client_id');
            return null;
        }
        if (empty(config('streams.twitch.client_secret'))) {
            Log::info('Stream .env miss client_secret');
            return null;
        }

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
