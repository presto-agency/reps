<?php

namespace App\Models;

use App\Traits\ModelRelations\StreamRelationTrait;
use Carbon\Carbon;
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
    public function getSrcIframe(): string
    {
        $src = $this->stream_url_iframe;
        if (!empty($src)) {
            $host = parse_url(htmlspecialchars_decode($src))['host'];
            if ($host === config('streams.twitch.host_i')) {
                return $src.'&parent='.request()->getHttpHost();
            }
        }
        return $src;
    }

    /**
     * @param  array  $data
     * @return bool
     */
    public static function createFromBroadcastWatch(array $data)
    {
        try {
            $dataForInsert = [];
            $races = Race::all();

            foreach ($data as $element) {
                $source = optional($element)['source'];
                $channel = optional($element)['channel'];
                $stream_url = self::setStreamUrlDefiler($source, $channel);

                if (self::query()->where('stream_url', $stream_url)->exists()) {
                    continue;
                }
                $race = $races->first(function ($value, $key) use ($element) {
                    return trim(mb_strtolower($value->title)) === $element['race'];
                });
                $race_id = optional($race)->id;

                $dataForInsert[] = [
                    'race_id'           => $race_id,
                    'title'             => optional($element)['name'],
                    'content'           => optional($element)['description'].' '.optional($element)['info'],
                    'stream_url'        => $stream_url,
                    'stream_url_iframe' => self::setStreamUrlIframeDefiler($source, $channel),
                    'active'            => 1,
                    'approved'          => 1,
                    'data'              => json_encode(['defiler' => $element]),
                    'created_at'        => Carbon::now()->toDateTimeString(),
                ];

            }

            self::query()->insert($dataForInsert);
            return true;
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return false;
        }
    }

    /**
     * @param $source
     * @param $channel
     * @return string|null
     */
    private static function setStreamUrlDefiler($source, $channel)
    {
        switch ($source) {
            case 'twitch':
                return "https://www.twitch.tv/$channel";
            case 'afreeca':
                return "https://play.afreecatv.com/$channel";
            case 'goodgame':
                return "https://goodgame.ru/channel/$channel/#autoplay";
            default:
                return null;
        }
    }

    /**
     * @param $source
     * @param $channel
     * @return string|null
     */
    private static function setStreamUrlIframeDefiler($source, $channel)
    {
        switch ($source) {
            case 'twitch':
                return "https://player.twitch.tv/?volume=0.5&!muted&channel=$channel";
            case 'afreeca':
                return "https://play.afreecatv.com/$channel/embed";
            case 'goodgame':
                return "https://goodgame.ru/channel/$channel/#autoplay";
            default:
                return null;
        }
    }
}
