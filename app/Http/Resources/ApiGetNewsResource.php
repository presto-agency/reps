<?php

namespace App\Http\Resources;

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
    public function toArray($request)
    {
        return [
            'id'             => $this->id,
            'news'           => $this->news,
            'user'           => [
                'id'     => $this->id,
                'name'   => $this->name,
                'avatar' => $this->avatar,
            ],
            'title'          => $this->title,
            'rating'         => $this->rating,
            'reviews'        => $this->reviews,
            'content'        => $this->content,
            'previewImg'     => $this->preview_img,
            'commentsCount'  => $this->comments_count,
            'previewContent' => $this->preview_content,
        ];
    }

}
