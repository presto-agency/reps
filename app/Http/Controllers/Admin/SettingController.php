<?php

namespace App\Http\Controllers\Admin;

use AdminSection;
use App\Http\Controllers\Controller;
use Cache;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Log;

/**
 * Class SettingController
 *
 * @package App\Http\Controllers\Admin
 */
class SettingController extends Controller
{

    /**
     * @return Factory|View
     */
    public function show()
    {

        return AdminSection::view(view('admin.settings')
            ->with('count_load_news', self::countLoadNews())
            ->with('count_load_important_news', self::countLoadImportantNews())
            ->with('count_load_fix_news', self::countLoadFixNews()
            ), 'Settings');
    }

    public static function countLoadNews()
    {
        if (Cache::has('count_load_news') && !empty(Cache::get('count_load_news'))) {
            return (int) Cache::get('count_load_news');
        }

        return 3;
    }

    public static function countLoadImportantNews()
    {
        if (Cache::has('count_load_important_news') && !empty(Cache::get('count_load_important_news'))) {
            return (int) Cache::get('count_load_important_news');
        }

        return 3;
    }

    public static function countLoadFixNews()
    {
        if (Cache::has('count_load_fix_news') && !empty(Cache::get('count_load_fix_news'))) {
            return (int) Cache::get('count_load_fix_news');
        }

        return 50;
    }

    public function save(Request $request)
    {
        try {
            Cache::forever('count_load_news', $request->count_load_news);
            Cache::forever('count_load_important_news', $request->count_load_important_news);
            Cache::forever('count_load_fix_news', $request->count_load_fix_news);
            return redirect()->back()->with('success', 'Дія виконана успішно');
        } catch (Exception $e) {
            Log::error($e->getMessage());

            return redirect()->back()->with('error', 'Помилка при оновлені');
        }
    }

}
