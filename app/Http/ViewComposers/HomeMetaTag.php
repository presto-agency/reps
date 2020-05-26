<?php


namespace App\Http\ViewComposers;

use App\Models\MetaTag;
use Cache;
use Illuminate\View\View;

class HomeMetaTag
{

    private static $ttl = 86400;//24 hours

    private $metaTags;

    public function __construct()
    {
        $this->metaTags = self::getCacheMetaTag('meta_tags');
    }

    public function compose(View $view)
    {
        $view->with('metaTags', $this->metaTags);
    }

    /**
     * @param  string  $cache_name
     *
     * @return mixed
     */
    private static function getCacheMetaTag(string $cache_name)
    {
        if (Cache::has($cache_name) && ! empty(Cache::get($cache_name))) {
            $data_cache = Cache::get($cache_name);
        } else {
            $data_cache = Cache::remember($cache_name, self::$ttl, function () {
                return MetaTag::query()->first();
            });
        }

        return $data_cache;
    }

}
