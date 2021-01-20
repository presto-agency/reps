<?php


namespace App\Http\ViewComposers\RightSide;

use App\Models\Banner;
use App\User;
use Illuminate\View\View;


class LastRegisteredUsersComposer
{

    private $ttl = 300;// 5 mints
    private $banners;
    private $users;

    public function __construct()
    {
        $this->banners = collect();
        $this->users   = collect();

        $banners = $this->getCacheBanners('banners', 30000);// 10 hours
        $users   = $this->getCacheUsers('newUsers');

        $this->banners = $banners;
        $this->users   = $users;
    }

    public function compose(View $view)
    {
        $view->with('banners', $this->banners);
        $view->with('newUsers', $this->users);
    }

    /**
     * @param  string  $cache_name
     * @param  int  $ttl
     *
     * @return mixed
     */
    public function getCacheBanners(string $cache_name, int $ttl)
    {
        if (\Cache::has($cache_name) && !empty(\Cache::get($cache_name))) {
            $data_cache = \Cache::get($cache_name);
        } else {
            $data_cache = \Cache::remember($cache_name, $ttl, function () {
                return $this->getBanners();
            });
        }

        return $data_cache;
    }

    /**
     * @param  string  $cache_name
     *
     * @return mixed
     */
    public function getCacheUsers(string $cache_name)
    {
        if (\Cache::has($cache_name) && !empty(\Cache::get($cache_name))) {
            $data_cache = \Cache::get($cache_name);
        } else {
            $data_cache = \Cache::remember($cache_name, $this->ttl, function () {
                return $this->getNewUsers();
            });
        }

        return $data_cache;
    }

    /**
     * @return mixed
     */
    private function getBanners()
    {
        return Banner::whereNotNull('image')->where('is_active', true)->get();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    private function getNewUsers()
    {
        return User::with('countries:id,flag,name', 'races:id,code,title')
            ->whereNotNull('email_verified_at')
            ->latest('created_at')
            ->limit(5)
            ->get(['id', 'name', 'race_id', 'country_id']);
    }

}
