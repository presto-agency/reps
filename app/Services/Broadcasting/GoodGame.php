<?php


namespace App\Services\Broadcasting;

use GuzzleHttp\Client;

/**
 * Documentation API http://api2.goodgame.ru/apigility/documentation/Goodgame-v2
 *
 * Class GoodGame
 *
 * @package App\Services\Broadcasting
 */
class GoodGame
{

    /**
     * See config->streams
     *
     * @base_uri
     */
    public static $base_uri;

    /**
     * @param $chanelName
     * @param $id
     *
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getStatus($chanelName, $id)
    {
        self::$base_uri = config('streams.goodgame.base_uri');

        $client = new  Client ([
            'base_uri' => self::$base_uri,
            'headers'  => [
                'Accept'       => 'application/json',
                'Content-Type' => 'application/json',
            ],
        ]);

        $response = $client->request('GET', 'streams/'.$chanelName);

        $data               = [];
        $data['host']       = config('streams.goodgame.host');
        $data['chanelName'] = $chanelName;

        $prepareContent = json_decode($response->getBody()->getContents());

        $getStatus      = ! empty($prepareContent->status)
            ? ($prepareContent->status == 'Live' ? config('streams.status')
                : null) : null;
        $data['status'] = $getStatus;
        $data['id']     = $id;

        return $data;

    }

}
