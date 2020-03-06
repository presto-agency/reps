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
     * @param  string  $url
     */
    public function __construct(string $url)
    {
        $this->parser($url);

        $this->isValidHost = $this->checkHost();
    }

    /**
     * @param $url
     */
    private function parser($url)
    {
        $url = parse_url(htmlspecialchars_decode($url));

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
     * @return string|null
     */
    public function getSrcIframe()
    {
        if ($this->isValidHost) {
            return $this->parseQuery();
        } else {
            return null;
        }
    }

    /**
     * @return string|null
     */
    private function parseQuery()
    {
        switch ($this->host) {
            case 'youtu.be':
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
        $part1 = config('src_iframe.embed')['youtu.be'];
        $query = $this->query;
        if ( ! empty($this->query) && $this->query[0] == "t") {
            $query = substr_replace($this->query, '?start', 0, 1);
        }
        $part2 = $this->path.$query;

        return "{$part1}{$part2}";
    }

    /**
     * @return string|null
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
            if (isset($parse[$key])) {
                $part2 = $parse[$key];

                return "{$part1}{$part2}";
            } else {
                return null;
            }
        } else {
            return null;
        }
    }


}
