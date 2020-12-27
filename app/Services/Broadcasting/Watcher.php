<?php


namespace App\Services\Broadcasting;

use GuzzleHttp\Client;

//use GuzzleHttp\Exception\GuzzleException;
//use GuzzleHttp\Exception\GuzzleException;

/**
 * Class Watcher
 * @package App\Services\Broadcasting
 */
class Watcher
{

    /**
     * @var array
     */
    protected $endpoints;

    /**
     * Watcher constructor.
     */
    public function __construct()
    {
        $this->setEndpoints();
    }

    private function setEndpoints()
    {
        $this->endpoints = config('streams.watcher.endpoints', []);
    }

    private function getEndpoints()
    {
        return $this->endpoints;
    }

    /**
     * @param  string  $endpoint
     * @return mixed|null
     */
    private function getEndpoint(string $endpoint)
    {
        $endpoints = $this->getEndpoints();

        if (array_key_exists($endpoint, $endpoints)) {
            return $endpoints[$endpoint];
        }

        return null;
    }

    /**
     * @param  string  $endpoint
     * @return mixed|null
     */
    public function getData(string $endpoint)
    {
        $url = $this->getEndpoint($endpoint);

        if (is_null($url)) {
            return null;
        }

        $client = new  Client ([
            'base_uri' => $url,
            'headers'  => [
                'Accept'       => 'application/json',
                'Content-Type' => 'application/json;charset=UTF-8',
                'Charset'      => 'utf-8'
            ],
        ]);

        try {
            $response = $client->request('GET');
            $prepareContent = json_decode($response->getBody()->getContents(), true);
            return optional($prepareContent)['streams'];
        } catch (\GuzzleHttp\Exception\GuzzleException  | \Exception $e) {
            \Log::error($e->getMessage());
            return null;
        }

    }
}
