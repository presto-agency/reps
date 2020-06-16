<?php

namespace App\Models;

use App\Traits\ModelRelations\StreamRelationTrait;
use Illuminate\Database\Eloquent\Model;

class Stream extends Model
{

    use StreamRelationTrait;

    protected $fillable
        = [

            'user_id',
            'title',
            'race_id',
            'content',
            'country_id',
            'stream_url',
            'stream_url_iframe',
            'approved',
            'active',

        ];

    /**
     * @return string
     */
    public function getSrcIframe():string
    {
        $src = $this->stream_url_iframe;
        if (!empty($src)){
            $host = parse_url(htmlspecialchars_decode($src))['host'];
            if ($host === config('streams.twitch.host_i')){
               return $src.'&parent='.request()->getHttpHost();
            }
        }
        return $src;
    }
}
