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
    public function getStatus($chanelName, $id)
    {
        self::$base_uri = config('streams.twitch.base_uri');
        self::$client_id = config('streams.twitch.client_id');
        $client = new  Client ([
            'headers' => [
                'Client-ID' => self::$client_id,
                'Accept:'   => 'application/json',
            ],
        ]);
        $url = self::$base_uri . 'streams/' . $chanelName;
        $response = $client->request('GET', $url);
        $prepareContent = json_decode($response->getBody()->getContents());
        $data = [];
        $data['host'] = config('streams.twitch.host');
        $data['chanelName'] = $chanelName;
        $data['status'] = $prepareContent->stream != null ? config('streams.status') : null;
        $data['id'] = $id;

        return $data;

    }
}
