<?php


namespace App\Services\Broadcasting;

use GuzzleHttp\Client;

/**
 * Documentation API https://dev.twitch.tv/docs/v5/reference/search/#search-channels
 *
 * Class Twitch
 * @package App\Services\Broadcasting
 */
class Twitch
{
    /**
     * See config->streams
     * @base_uri
     * @client_id
     */
    public static $base_uri;
    private static $client_id;

    /**
     * @param $chanelName
     * @param $id
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getStatus($chanelName,$id)
    {
        self::$base_uri = config('streams.twitch.base_uri');
        self::$client_id = config('streams.twitch.client_id');


        $client = new  Client ([
            'base_uri' => self::$base_uri,
            'headers' => [
                'Client-ID' => self::$client_id,
                'Accept' => 'application/vnd.twitchtv.v5+json',
                'Content-Type' => 'application/json',
            ],
        ]);

        $response = $client->request('GET', "search/streams?query=" . $chanelName);

        $data = [];
        $data['host'] = config('streams.twitch.host');
        $data['chanelName'] = $chanelName;

        $prepareContent = json_decode($response->getBody()->getContents());

        $getStream = !empty($prepareContent->streams) ? reset($prepareContent->streams) : null;
        $data['status'] = !empty($getStream->stream_type) ? ($getStream->stream_type == 'live' ? config('streams.status') : null) : null;
        $data['id'] = $id;


        return $data;

    }
}
