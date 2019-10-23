<?php


namespace App\Http\ViewComposers;

use App\User;
use Illuminate\View\View;


class SidebarRightComposer
{
    private $categoryNewUser;

    public function __construct()
    {
        $this->categoryNewUser = collect();

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
                    'countryFlag25x20' => self::pathToFlag25x20($item->countries->flag),
                ];
            }
        }

        return $data;
    }

    /**
     * @param $filePath
     * @return string
     */
    public static function pathToFlag25x20($filePath)
    {
        $ext = ".png";
        $filename = self::getFileName($filePath);
        return "storage/image/county/flag/25x20/$filename$ext";
    }

    /**
     * @param $filePath
     * @return mixed
     */
    public static function getFileName($filePath)
    {
        $getImgName1 = explode('/', $filePath);
        $getImgName2 = explode('.', end($getImgName1));
        return $fileName = reset($getImgName2);
    }


}
