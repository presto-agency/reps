<?php

namespace App\Observers;

use App\Models\Stream;

class StreamObserver
{

    public static function goodGameUrl()
    {
    }

    public static function twitchUrl()
    {
    }

    public static function afreecaTvUrl()
    {
    }

    public function creating(Stream $stream)
    {
        self::liveStreamCheck($stream->getAttribute('stream_url'), $stream);

        $this->setUserIdAttribute($stream);
    }

    /**
     * @param $stream_url
     * @param $stream
     *
     * @return bool|void
     */
    public static function liveStreamCheck($stream_url, $stream)
    {
        if (!empty($stream_url)) {

            $parseUrl = self::parse_stream_url($stream_url);
            $getHost = !empty($parseUrl['host']) ? $parseUrl['host'] : null;

            if ($getHost == config('streams.twitch.host')) {
                $parsePath = explode('/', $parseUrl['path']);
                $getChannelName = end($parsePath);
                $setNewTwitchUrl = "https://player.twitch.tv/?volume=0.5&!muted&channel={$getChannelName}";
                $stream->setAttribute('stream_url_iframe', $setNewTwitchUrl);
                $stream->setAttribute('channel', mb_strtolower($getChannelName));
                $stream->setAttribute('resource', $getHost);
            }
            if ($getHost == config('streams.goodgame.host')) {
                $parsePath = explode('/', $parseUrl['path']);
                $getChannelName = $parsePath[2];
                $setNewTwitchUrl = "https://goodgame.ru/channel/{$getChannelName}/#autoplay";
                $stream->setAttribute('stream_url_iframe', $setNewTwitchUrl);
                $stream->setAttribute('channel', mb_strtolower($getChannelName));
                $stream->setAttribute('resource', $getHost);
            }
            if ($getHost == config('streams.afreecatv.host')) {
                $parsePath = explode('/', $parseUrl['path']);
                $getChannelName = $parsePath[1];
                $setNewTwitchUrl = "https://play.afreecatv.com/{$getChannelName}/embed";
                $stream->setAttribute('stream_url_iframe', $setNewTwitchUrl);
                $stream->setAttribute('channel', mb_strtolower($getChannelName));
                $stream->setAttribute('resource', $getHost);
            }
        }
    }

    private static function parse_stream_url($url)
    {
        return parse_url(htmlspecialchars_decode($url));
    }

    private function setUserIdAttribute($data)
    {
        return $data['user_id'] = auth()->id();
    }

    /**
     * Handle the stream "created" event.
     *
     * @param  Stream  $stream
     *
     * @return void
     */
    public function created(Stream $stream)
    {
    }

    public function updating(Stream $stream)
    {
        self::liveStreamCheck($stream->getAttribute('stream_url'), $stream);

//        $this->setUserIdAttribute($stream);
    }

    /**
     * Handle the stream "updated" event.
     *
     * @param  Stream  $stream
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
     * @param  Stream  $stream
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
     * @param  Stream  $stream
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
     * @param  Stream  $stream
     *
     * @return void
     */
    public function forceDeleted(Stream $stream)
    {
        //
    }

}
