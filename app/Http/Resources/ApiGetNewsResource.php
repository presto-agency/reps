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
        $bbCode = new BBCode();

        return [
            'id'             => $this->id,
            'title'          => clean($this->title),
            'content'        => $this->convertToBBCode($this->content, $bbCode),
            'previewImg'     => !empty($this->preview_img) ? $this->preview_img : '',
            'previewImgFull' => !empty($this->preview_img) ? asset($this->preview_img) : '',
            'previewContent' => $this->convertToBBCode($this->preview_content, $bbCode),
            'createdAt'      => $this->created_at,
        ];
    }

    /**
     * @param $text
     * @param  BBCode  $bbCode
     * @return mixed|string
     */
    private function convertToBBCode($text, BBCode $bbCode)
    {
        $text = trim($text);
        if (empty($text)) {
            return $text;
        }

        try {

            $imgReplace = preg_replace('/<img (.*?) src="(.*?)" (.*?) \/>/s', "[img]$2[/img]", $text);
            if (!empty($imgReplace)) {
                $text = $imgReplace;
            }
            $imgReplace2 = preg_replace('/<img(.*?)src="(.*?)"(.*?)\/>/s', "[img]$2[/img]", $text);
            if (!empty($imgReplace2)) {
                $text = $imgReplace2;
            }

            $iframeReplace = preg_replace('/<iframe (.*?) src="(.*?)" (.*?)><\/iframe>/s', "[iframe]$2[/iframe]", $text);

            if (!empty($iframeReplace)) {
                $text = $iframeReplace;
            }

            $text = $bbCode->convertFromHtml($text);

            return clean($text);

        } catch (\Exception $e) {
            \Log::error($e->getMessage());
        }
        return '';
    }

}
