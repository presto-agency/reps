<?php

namespace App\Http\Resources;


use Genert\BBCode\BBCode;
use Illuminate\Http\Resources\Json\JsonResource;

class ApiGetNewsResource extends JsonResource
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
            'id'             => (int) $this->id,
            'title'          => (string) clean($this->title),
            'rating'         => (int) $this->rating,
            'reviews'        => (int) $this->reviews,
            'content'        => clean($this->convertToBBCode($this->content)),
            'previewImg'     => (string) $this->preview_img,
            'previewContent' => clean($this->convertToBBCode($this->preview_content)),
            'commentsCount'  => (int) $this->comments_count,
        ];
    }

    /**
     * @param  string  $text
     *
     * @return string
     */
    private function convertToBBCode($text): string
    {
        $bbCode = new BBCode();

        $bbCode->addHtmlParser('p', '/<p>(.*?)<\/p>/s', '$1', '$1');
        $bbCode->addHtmlParser('img2', '/<img (.*?) src="(.*?)" (.*?)>/s', '[img]$2[/img]', '$2');

        return $bbCode->convertFromHtml(html_entity_decode($text));
    }

}
