<?php


namespace App\Http\ViewComposers\Footer;


use App\Models\{Footer, FooterUrl};
use App\User;
use Carbon\Carbon;
use Illuminate\View\View;

class FooterComposer
{
    private static $ttl = 300;

    public function compose(View $view)
    {
        $view->with('footer', self::getCacheFooter('footer'));
        $view->with('footerUrl', self::getCacheFooterUrl('footerUrl'));
        $view->with('footerUser', self::getCacheFooterUser('footerUser'));
    }

    public static function getCacheFooter($cache_name)
    {
        if (\Cache::has($cache_name) && !empty(\Cache::get($cache_name))) {
            $data_cache = \Cache::get($cache_name);
        } else {
            $data_cache = \Cache::remember($cache_name, self::$ttl, function () {
                return self::getFooter();
            });
        }
        return $data_cache;
    }

    public static function getCacheFooterUrl($cache_name)
    {
        if (\Cache::has($cache_name) && !\Cache::get($cache_name)->isEmpty()) {
            $data_cache = \Cache::get($cache_name);
        } else {
            $data_cache = \Cache::remember($cache_name, self::$ttl, function () {
                return self:: getFooterUrl();
            });
        }
        return $data_cache;
    }

    public static function getCacheFooterUser($cache_name)
    {
        if (\Cache::has($cache_name) && !\Cache::get($cache_name)->isEmpty()) {
            $data_cache = \Cache::get($cache_name);
        } else {
            $data_cache = \Cache::remember($cache_name, self::$ttl, function () {
                return self::getFooterUser();
            });
        }
        return $data_cache;
    }

    private static function getFooter()
    {
        $data = null;
        $data = Footer::where('approved', 1)->value('text');
        return $data;
    }

    private static function getFooterUrl()
    {
        $data = null;
        $data = FooterUrl::where('approved', 1)->get(['title', 'url']);
        return $data;
    }

    private static function getFooterUser()
    {
        $data = null;
        $data = User::where('birthday', Carbon::now()->format('Y-m-d'))->get(['id', 'name']);
        return $data;
    }
}
