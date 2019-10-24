<?php


namespace App\Http\ViewComposers;

use App\User;
use Illuminate\View\View;


class SidebarRightComposer
{
    private $categoryNewUser;

    public function __construct()
    {
        $this->categoryNewUser = self::getNew5Users();
    }

    /**
     * @param View $view
     */
    public function compose(View $view)
    {
        $view->with('newUsers', $this->categoryNewUser);
    }

    /**
     * @return array
     */
    public static function getNew5Users()
    {
        $data = [];

        $getData = User::with('countries:id,flag', 'races:id,title')
            ->orderBy('id', 'desc')
            ->take(5)
            ->get(['id', 'name', 'race_id', 'country_id']);

        if (!$getData->isEmpty()) {
            foreach ($getData as $item) {
                $data[] = [
                    'id' => $item->id,
                    'name' => $item->name,
                    'raceIcon' => $item->races->title,
                    'countryFlag25x20' => $item->countries->flag,
                ];
            }
        }

        return $data;
    }

}
