<?php


namespace App\Services\SrcFromUrl;

/**
 * Class Generator
 *
 * @package App\Services\SrcFromUrl
 */
class Generator
{

    /**
     * @var
     */
    public $scheme;
    /**
     * @var
     */
    public $host;
    /**
     * @var
     */
    public $path;
    /**
     * @var
     */
    public $query;

    public $isValidHost;

    /**
     * Generator constructor.
     *
     * @param $url
     */
    public function __construct($url)
    {
        $this->parser($url);

        $this->isValidHost = $this->checkHost();
    }

    /**
     * @param $url
     */
    private function parser($url)
    {
        $url          = parse_url(htmlspecialchars_decode($url));
        $this->scheme = isset($url['scheme']) ? $url['scheme'] : null;
        $this->host   = isset($url['host']) ? $url['host'] : null;
        $this->path   = isset($url['path']) ? $url['path'] : null;
        $this->query  = isset($url['query']) ? $url['query'] : null;
    }

    /**
     * @return bool
     */
    private function checkHost(): bool
    {
        return in_array($this->host, config('src_iframe.hosts'));
    }

    /**
     * @return bool|false|string|null
     */
    public function getSrcIframe()
    {
        if ($this->isValidHost) {
            return $this->parseQuery();
        } else {
            return false;
        }
    }

    /**
     * @return string|null
     */
    private function parseQuery()
    {
        switch ($this->host) {
            case 'www.youtube.com':
                return $this->getYoutube();
                break;
            case 'www.twitch.tv':
                return $this->getTwitch();
                break;
            default;
                return null;
                break;
        }
    }

    /**
     * @return string
     */
    private function getYoutube()
    {
        $part1 = config('src_iframe.embed')['www.youtube.com'];
        $part2 = substr($this->query, strpos($this->query, "v=") + 2);

        return "{$part1}{$part2}";
    }

    /**
     * @return mixed
     */
    private function getTwitch()
    {
        $parse = explode("/", $this->path);

        if (in_array('videos', $parse)) {
            $part1 = config('src_iframe.embed')['www.twitch.tv']['video'];
            $part2 = $parse[2];

            return "{$part1}{$part2}";
        } elseif (in_array('clip', $parse)) {
            $part1 = config('src_iframe.embed')['www.twitch.tv']['clip'];
            $key   = array_search('clip', $parse) + 1;
            $part2 = isset($parse[$key]) ? $parse[$key] : null;
           
            return "{$part1}{$part2}";
        } else {
            return null;
        }
    }


}
