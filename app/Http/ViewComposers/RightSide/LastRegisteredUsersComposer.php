<?php


namespace App\Http\ViewComposers\RightSide;

use App\User;
use Illuminate\View\View;
use phpDocumentor\Reflection\Types\Null_;


class LastRegisteredUsersComposer
{
    private static $userTake = 5;

    /**
     * @param View $view
     */
    public function compose(View $view)
    {
        $view->with('newUsers', self::getNewUsers());
    }

    /**
     * @return array
     */
    private static function getNewUsers()
    {
        $data = null;

        $getData = User::with('countries:id,flag', 'races:id,title')
            ->orderBy('id', 'desc')
            ->take(self::$userTake)
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
