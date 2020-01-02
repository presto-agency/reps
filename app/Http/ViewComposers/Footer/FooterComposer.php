<?php


namespace App\Http\ViewComposers\Footer;


use App\Models\{Footer, FooterUrl};
use App\User;
use Cache;
use Carbon\Carbon;
use Illuminate\View\View;

class FooterComposer
{

    private $ttl = 36000;//10 hours

    private $footer;
    private $footerUrl;
    private $footerUser;

    public function __construct()
    {
        $this->footer     = null;
        $this->footerUrl  = collect();
        $this->footerUser = collect();

        $footer     = $this->getCacheFooter('footer');
        $footerUrl  = $this->getCacheFooterUrl('footerUrl');
        $footerUser = $this->getCacheFooterUser('footerUser');

        $this->footer     = $footer;
        $this->footerUrl  = $footerUrl;
        $this->footerUser = $footerUser;
    }


    public function compose(View $view)
    {
        $view->with('footer', $this->footer);
        $view->with('footerUrl', $this->footerUrl);
        $view->with('footerUser', $this->footerUser);
    }

    /**
     * @param  string  $cache_name
     *
     * @return mixed
     */
    private function getCacheFooter(string $cache_name)
    {
        if (Cache::has($cache_name) && ! empty(Cache::get($cache_name))) {
            $data_cache = Cache::get($cache_name);
        } else {
            $data_cache = Cache::remember($cache_name, $this->ttl, function () {
                return $this->getFooter();
            });
        }

        return $data_cache;
    }

    /**
     * @param  string  $cache_name
     *
     * @return mixed
     */
    private function getCacheFooterUrl(string $cache_name)
    {
        if (Cache::has($cache_name) && Cache::get($cache_name)->isNotEmpty()) {
            $data_cache = Cache::get($cache_name);
        } else {
            $data_cache = Cache::remember($cache_name, $this->ttl, function () {
                return $this->getFooterUrl();
            });
        }

        return $data_cache;
    }

    /**
     * @param  string  $cache_name
     *
     * @return mixed
     */
    private function getCacheFooterUser(string $cache_name)
    {
        if (Cache::has($cache_name) && Cache::get($cache_name)->isNotEmpty()) {
            $data_cache = Cache::get($cache_name);
        } else {
            $data_cache = Cache::remember($cache_name, $this->ttl, function () {
                return $this->getFooterUser();
            });
        }

        return $data_cache;
    }

    /**
     * @return mixed
     */
    private function getFooter()
    {
        return Footer::whereApproved(true)->value('text');
    }

    /**
     * @return mixed
     */
    private function getFooterUrl()
    {
        return FooterUrl::whereApproved(true)->get(['title', 'url']);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    private function getFooterUser()
    {
        return User::where('birthday', 'like', "%".Carbon::now()->format('m-d'))->take(5)->get(['id', 'name']);
    }

}
