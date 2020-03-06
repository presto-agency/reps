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
            'content'        => $this->convertToBBCode((string) $this->content),
            'previewImg'     => ! empty($this->preview_img) ? asset($this->preview_img) : '',
            'previewContent' => $this->convertToBBCode((string) $this->preview_content),
            'createdAt'      => $this->created_at,
        ];
    }

    /**
     * @param $text
     *
     * @return string|null
     */
    private function convertToBBCode($text)
    {
        try {
            $bbCode = new BBCode();
            $text   = trim($text);
            $text   = str_replace('<p>', '', $text);
            $text   = str_replace('</p>', '', $text);
            $text   = str_replace('&nbsp;', '', $text);

            $imgReplace = preg_replace('/<img (.*?) src="(.*?)" (.*?) \/>/m', "[img]$2[/img]", $text);
            if ( ! empty($imgReplace)) {
                $text = $imgReplace;
            }

            $iframeReplace = preg_replace('/<iframe (.*?) src="(.*?)" (.*?)><\/iframe>/m', "[iframe]$2[/iframe]", $text);

            if ( ! empty($iframeReplace)) {
                $text = $iframeReplace;
            }

            $bbCode = $bbCode->convertFromHtml($text);


            return $bbCode;
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
        }
    }

}
