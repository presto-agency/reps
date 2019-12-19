<?php


namespace App\Http\ViewComposers\Footer;


use App\Models\{Footer, FooterUrl};
use App\User;
use Cache;
use Carbon\Carbon;
use Illuminate\View\View;

class FooterComposer
{

    private static $ttl = 300;

    public function compose(View $view)
    {
        $view->with('footer', self::getCache('footer', self::getFooter()));
        $view->with('footerUrl', self::getCache('footerUrl', self:: getFooterUrl()));
        $view->with('footerUser', self::getCache('footerUser', self::getFooterUser()));
    }

    public static function getCache($cache_name, $data)
    {
        if (Cache::has($cache_name) && ! empty(Cache::get($cache_name))) {
            $data_cache = Cache::get($cache_name);
        } else {
            $data_cache = Cache::remember($cache_name, self::$ttl, function () use ($data) {
                return $data;
            });
        }

        return $data_cache;
    }

    private static function getFooter()
    {
        return Footer::where('approved', 1)->value('text');
    }

    private static function getFooterUrl()
    {
        return FooterUrl::where('approved', 1)->get(['title', 'url']);
    }

    private static function getFooterUser()
    {
        return User::where('birthday', 'like', "%".Carbon::now()->format('m-d'))->get(['id', 'name']);
    }

}
