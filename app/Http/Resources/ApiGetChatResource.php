<?php

namespace App\Http\Resources;


use Illuminate\Http\Resources\Json\JsonResource;

class ApiGetChatResource extends JsonResource
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
            'id'        => $this->id,
            'userName'  => $this->user_name,
            'message'   => $this->message,
            'createdAt' => $this->created_at,
        ];
    }

}
