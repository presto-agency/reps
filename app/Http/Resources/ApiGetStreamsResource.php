<?php

namespace App\Http\Resources;


use Illuminate\Http\Resources\Json\JsonResource;

class ApiGetStreamsResource extends JsonResource
{

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return array
     */
    public function toArray($request): array
    {
        $parts = self::parseUrl($this->stream_url);
        $source = self::getSource($parts);
        $channel = self::getChannel($parts, $source);
        return [
            'id'               => $this->id,
            'race'             => optional($this->races)->title,
            'country'          => optional($this->countries)->name,
            'title'            => clean($this->title),
            'content'          => $this->content,
            'streamUrl'        => $this->stream_url,
            'streamUrlIframe ' => $this->stream_url_iframe,
            'approved'         => (boolean) $this->approved,
            'source'           => $source,
            'channel'          => $channel,
        ];
    }

    /**
     * @param $stream_url
     * @return array|false|int|string|null
     */
    private static function parseUrl($stream_url)
    {
        return parse_url(htmlspecialchars_decode($stream_url));
    }

    /**
     * @param $parts
     * @return |null
     */
    private static function getSource($parts)
    {
        if (empty($parts['host'])) {
            return null;
        }
        return $parts['host'];
    }

    /**
     * @param $parts
     * @param $source
     * @return mixed|string|null
     */
    private static function getChannel($parts, $source)
    {
        try {
            switch ($source) {
                case config('streams.goodgame.host'):
                    return explode('/', $parts['path'])[2];
                case config('streams.afreecatv.host'):
                case config('streams.twitch.host'):
                    return explode('/', $parts['path'])[1];
                default:
                    return null;
            }
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return null;
        }

    }
}
