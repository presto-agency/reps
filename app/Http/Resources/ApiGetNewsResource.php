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
            'content'        => $this->convertToBBCode((string) $this->content),
            'previewImg'     => (string) $this->preview_img,
            'previewContent' => $this->convertToBBCode((string) $this->preview_content),
            'commentsCount'  => (int) $this->comments_count,
        ];
    }

    /**
     * @param  string  $text
     *
     * @return string
     */
    private function convertToBBCode(string $text): string
    {
        $bbCode = new BBCode();
        $text1  = str_ireplace('<p>', '', $text);
        $text2  = str_ireplace('</p>', '', $text1);

        return $bbCode->convertFromHtml($text2);
    }

}
