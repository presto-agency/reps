<?php

namespace App\Observers;

use App\Models\Stream;

class StreamObserver
{

    public function creating(Stream $stream)
    {

        self::liveStreamCheck($stream->getAttribute('stream_url'), $stream);

        $this->setUserIdAttribute($stream);
    }

    /**
     * Handle the stream "created" event.
     *
     * @param Stream $stream
     *
     * @return void
     */
    public function created(Stream $stream)
    {

    }

    public function updating(Stream $stream)
    {

        self::liveStreamCheck($stream->getAttribute('stream_url'), $stream);

        $this->setUserIdAttribute($stream);
    }

    /**
     * Handle the stream "updated" event.
     *
     * @param Stream $stream
     *
     * @return void
     */
    public function updated(Stream $stream)
    {
        //
    }

    /**
     * Handle the stream "deleted" event.
     *
     * @param Stream $stream
     *
     * @return void
     */
    public function deleted(Stream $stream)
    {
        //
    }

    /**
     * Handle the stream "restored" event.
     *
     * @param Stream $stream
     *
     * @return void
     */
    public function restored(Stream $stream)
    {
        //
    }

    /**
     * Handle the stream "force deleted" event.
     *
     * @param Stream $stream
     *
     * @return void
     */
    public function forceDeleted(Stream $stream)
    {
        //
    }

    private function setUserIdAttribute($data)
    {
        return $data['user_id'] = auth()->id();

    }

    /**
     * @param $stream_url
     * @param $stream
     *
     * @return bool|void
     */
    public static function liveStreamCheck($stream_url, $stream)
    {
        $parseUrl = self::parse_stream_url($stream_url);
        $getHost  = $parseUrl['host'];

        if ($getHost == config('streams.twitch.host')) {
            $parsePath     = explode('/', $parseUrl['path']);
            $getChanelName = end($parsePath);
            $setNewTwitchUrl
                           = "https://player.twitch.tv/?volume=0.5&!muted&channel=$getChanelName";
            $stream->setAttribute('stream_url_iframe', $setNewTwitchUrl);
        }
        if ($getHost == config('streams.goodgame.host')) {
            $parsePath     = explode('/', $parseUrl['path']);
            $getChanelName = $parsePath[2];
            $setNewTwitchUrl
                           = "https://goodgame.ru/channel/$getChanelName/#autoplay";
            $stream->setAttribute('stream_url_iframe', $setNewTwitchUrl);
        }
        if ($getHost == config('streams.afreecatv.host')) {
            $parsePath     = explode('/', $parseUrl['path']);
            $getChanelName = $parsePath[1];
            $setNewTwitchUrl
                           = "https://play.afreecatv.com/$getChanelName/embed";
            $stream->setAttribute('stream_url_iframe', $setNewTwitchUrl);
        }

        return false;
    }

    public static function goodGameUrl()
    {

    }

    public static function twitchUrl()
    {

    }

    public static function afreecaTvUrl()
    {
    }

    private static function parse_stream_url($url)
    {
        return parse_url(htmlspecialchars_decode($url));
    }

}
