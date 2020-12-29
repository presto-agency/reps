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
            'channel'          => $this->channel,
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
}
