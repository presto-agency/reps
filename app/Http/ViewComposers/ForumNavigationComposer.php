<?php
/**
 * Created by PhpStorm.
 * User: MAX
 * Date: 18.10.2019
 * Time: 10:14
 */

namespace App\Http\ViewComposers;

use App\Models\ForumSection;
use Cache;
use Illuminate\View\View;

class ForumNavigationComposer
{

    private $ttl = 36000;//10 hours

    private $category;

    public function __construct()
    {
        $this->category = collect();

        $data = $this->getCacheForumSection('sectionItems');

        $this->category = $data;

    }

    public function compose(View $view)
    {
        $view->with('sectionItems', $this->category);
    }

    /**
     * @param  string  $cache_name
     *
     * @return mixed
     */
    private function getCacheForumSection(string $cache_name)
    {
        if (Cache::has($cache_name) && Cache::get($cache_name)->isNotEmpty()) {
            $data_cache = Cache::get($cache_name);
        } else {
            $data_cache = Cache::remember($cache_name, $this->ttl, function () {
                return $this->getForumSection();
            });
        }

        return $data_cache;
    }

    /**
     * @return mixed
     */
    private function getForumSection()
    {
        return ForumSection::where('is_active', true)->orderBy('position')->get(['id','title']);
    }
}
