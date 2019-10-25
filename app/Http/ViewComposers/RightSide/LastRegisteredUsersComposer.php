<?php


namespace App\Http\ViewComposers\RightSide;

use App\User;
use Illuminate\View\View;
use phpDocumentor\Reflection\Types\Null_;


class LastRegisteredUsersComposer
{
    private $newUsers;
    private  static $userTake = 5;

    public function __construct()
    {
        $this->newUsers = self::getNewUsers();
    }

    /**
     * @param View $view
     */
    public function compose(View $view)
    {
        $view->with('newUsers', $this->newUsers);
    }

    /**
     * @return array
     */
    public static function getNewUsers()
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
