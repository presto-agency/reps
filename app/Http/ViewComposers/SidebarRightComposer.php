<?php


namespace App\Http\ViewComposers;

use App\User;
use Illuminate\View\View;


class SidebarRightComposer
{
    private $categoryNewUser;
    private $categoryTop5Rating;

    public function __construct()
    {
        $this->categoryNewUser = collect();
        $this->categoryNewUser = $this->getNewUsers();
        dd($this->getTop5Rating());
        $this->categoryTop5Rating = $this->getTop5Rating();
    }

    /**
     * @param View $view
     */
    public function compose(View $view)
    {
        $view->with('newUsers', $this->categoryNewUser);
        $view->with('top5Rating', $this->categoryTop5Rating);
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

    /**
     * @return array
     */
    public function getNewUsers()
    {
        $data = [];
        $getData = User::with('countries:id,flag', 'races')
            ->orderBy('id', 'desc')
            ->take(5)
            ->get(['id', 'name', 'race_id', 'country_id']);
        if (!$getData->isEmpty()) {
            foreach ($getData as $item) {
                $data[] = [
                    'id' => $item->id,
                    'name' => $item->name,
                    'raceIcon' => $item->races->id,
                    'countryFlag25x20' => self::pathToFlag25x20($item->countries->flag),
                ];
            }
        }

        return $data;
    }

    public function getTop5Rating()
    {
        $data = [];
        $getData =  User::orderByRaw("(count_positive - count_negative) DESC")
            ->take(5)
            ->get();

        return $getData;
    }
}
