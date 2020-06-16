<?php


namespace App\Services\Broadcasting;

use Cache;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

/**
 * Documentation API
 * https://dev.twitch.tv/docs/v5/reference/search/#search-channels
 *
 * Class Twitch
 *
 * @package App\Services\Broadcasting
 */
class Twitch
{

    public static $ttl;

    /**
     * @param $chanelName
     * @param $id
     *
     * @return array
     * @throws GuzzleException
     */
    public function getStatus($chanelName, $id)
    {
        $client = new Client();


        $url = 'https://api.twitch.tv/helix/streams?user_login='.$chanelName;

        $response = $client->request('GET', $url, [
            'headers' => [
                'Client-ID'     => config('streams.twitch.client_id'),
                'Authorization' => "Bearer ".self::getOauthToken('twitch_oauth_token'),
                'Accept:'       => 'application/json',
            ],
        ]);

        $prepareContent = json_decode($response->getBody()->getContents(), true);

        $data['host']       = config('streams.twitch.host');
        $data['chanelName'] = $chanelName;
        $data['status']     = self::checkStatus($prepareContent);
        $data['id']         = $id;

        return $data;
    }

    private static function checkStatus(array $data)
    {
        $status = null;
        if ( ! empty($data['data'])) {
            if ($data['data'][0]['type'] === config('streams.status')) {
                $status = config('streams.status');
            }
        }


        return $status;
    }

    /**
     * @param  string  $cache_name
     *
     * @return string
     */
    private static function getOauthToken(string $cache_name): string
    {
        if (Cache::has($cache_name) && ! empty(Cache::get($cache_name))) {
            $data_cache = Cache::get($cache_name);
        } else {
            $data_cache = Cache::remember($cache_name, self::$ttl, function () {
                $token     = self::getToken();
                self::$ttl = json_decode($token)->expires_in;

                return json_decode($token)->access_token;
            });
        }

        return $data_cache;
    }

    /**
     * @return string
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    private static function getToken(): string
    {
        $client   = new Client();
        $response = $client->request('POST', 'https://id.twitch.tv/oauth2/token', [
            'json' => [
                'client_id'     => config('streams.twitch.client_id'),
                'client_secret' => config('streams.twitch.client_secret'),
                'grant_type'    => "client_credentials",
            ],
        ]);

        return $response->getBody()->getContents();
    }

}
