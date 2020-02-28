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
        //                dd($this->convertToBBCode($this->content));
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
     * @param $text
     *
     * @return string|null
     */
    private function convertToBBCode($text)
    {
        try {
            $bbCode = new BBCode();

//            $bbCode->addHtmlParser('p', '/<p>(.*?)<\/p>/s', '$1', '$1');
//
//            $bbCode->addHtmlParser('img', '/<img (.*?) src="(.*?)" (.*?)>/s', '[img]$1[/img]', '$1');
////
////            $bbCode->addHtmlParser('iframeSrc', '/<iframe (.*?) src="(.*?)" (.*?)><\/iframe>/s', '[iframeSrc $1 $3]$2[/iframe]', '$1,$2,$3');
//            $bbCode1 = preg_replace('/<img (.*?) src="(.*?)" (.*?)>/s', "[img]$1[/img]", $bbCode);
//            if (!empty($bbCode1)){
//                $bbCode = $bbCode1;
//            }
//            $bbCode2 = preg_replace('/<iframe (.*?) src="(.*?)" (.*?)><\/iframe>/s', "[iframeSrc $1 $3]$2[/iframe]", $bbCode);
//            if (!empty($bbCode1)){
//                $bbCode = $bbCode2;
//            }
//            dd($bbCode);
            $bbCode = $bbCode->convertFromHtml($text);
dd($bbCode);




        } catch (\Exception $e) {
            \Log::error($e->getMessage());
        }
    }

}
