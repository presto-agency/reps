<?php


namespace App\Http\ViewComposers\RightSide;


use App\Http\Controllers\Best\BestController;
use Illuminate\View\View;

class Top10Composer
{
    private $top10Rating;
    private $top10Points;

    public function __construct()
    {
        $data = new BestController;
        $this->top10Rating = $data->getTop10Rating();
        $this->top10Points = $data->getTop10Points();

    }

    public function compose(View $view)
    {
        $view->with('top10Rating', $this->top10Rating);
        $view->with('top10Points', $this->top10Points);
    }

}
