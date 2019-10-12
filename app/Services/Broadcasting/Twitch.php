<?php


namespace App\Services\Broadcasting;


use GuzzleHttp\Client;

class Twitch
{
    public function getStatus($chanelName)
    {

        $client = new  Client ([
            'base_uri' => 'https://api.twitch.tv/',
            'headers' => [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ],
        ]);

        $response = $client->request('GET', $chanelName.'/streams');
        $data = [];
        $data['StatusCode'] = $response->getStatusCode();
        $content = $response->getBody()->getContents();
        $data['Status'] = json_decode($content)->status;

        return $data;

    }
}
