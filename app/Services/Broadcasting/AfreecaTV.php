<?php


namespace App\Services\Broadcasting;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

/**
 * Class AfreecaTV
 *
 * @package App\Services\Broadcasting
 */
class AfreecaTV
{

    /**
     * See config->streams
     *
     * @base_uri
     * @client_id
     */
    public static $base_uri;

    /**
     * @param $chanelName
     * @param $id
     *
     * @return array
     * @throws GuzzleException
     */
    public function getStatus($chanelName, $id)
    {
        self::$base_uri = config('streams.afreecatv.base_uri');

        $client   = new  Client ([
            'base_uri' => self::$base_uri,
            'headers'  => [
                'Accept' => 'application/json',
            ],
        ]);
        $response = $client->request('POST', 'player_live_api.php', [
            'form_params' => [
                'bid'         => $chanelName,
                'bno'         => '',
                'type'        => '',
                'player_type' => 'html5',
                'stream_type' => 'common',
                'quality'     => '',
                'mode'        => 'embed',
            ],
        ]);

        $data               = [];
        $data['host']       = config('streams.afreecatv.host');
        $data['chanelName'] = $chanelName;

        $prepareContent = json_decode($response->getBody()->getContents());

        $getChannel = ! empty($prepareContent->CHANNEL)
            ? $prepareContent->CHANNEL : null;

        $getStatus      = ! empty($getChannel->RESULT) ? ($getChannel->RESULT
        == 1 ? config('streams.status') : null) : null;
        $data['status'] = $getStatus;
        $data['id']     = $id;

        return $data;
    }

}
