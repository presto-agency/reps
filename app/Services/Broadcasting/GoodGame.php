<?php


namespace App\Services\Broadcasting;

use GuzzleHttp\Client;

/**
 * Documentation Api
 * http://api2.goodgame.ru/apigility/documentation/Goodgame-v2
 * Class GoodGame
 * @package App\Services\Broadcasting
 */
class GoodGame
{

    /**
     * @param $chanelName
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getStatus($chanelName)
    {

        $client = new  Client ([
            'base_uri' => 'http://api2.goodgame.ru/',
            'headers' => [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ],
        ]);

        $response = $client->request('GET', 'streams/' . $chanelName);
        $data = [];
        $data['StatusCode'] = $response->getStatusCode();
        $content = $response->getBody()->getContents();
        $data['Status'] = json_decode($content)->status;

        return $data;

    }
}
