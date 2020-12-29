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
        return [
            'id'               => $this->id,
            'race'             => optional($this->races)->title,
            'country'          => optional($this->countries)->name,
            'title'            => clean($this->title),
            'content'          => $this->content,
            'streamUrl'        => $this->stream_url,
            'streamUrlIframe ' => $this->stream_url_iframe,
            'approved'         => (boolean) $this->approved,
            'source'           => $this->resource,
            'channel'          => $this->channel,
        ];
    }
}
