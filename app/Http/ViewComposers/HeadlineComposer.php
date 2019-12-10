<?php


namespace App\Http\ViewComposers;

use App\Models\Headline;
use Illuminate\View\View;

class HeadlineComposer
{
    private $category;

    public function __construct()
    {
        $data = [];

        $getData = Headline::get(['title']);

        if (!$getData->isEmpty()) {
            foreach ($getData as $item) {
                $data[] = [
                    'title' => $item->title,
                ];
            }
        }

        $this->category = $data;

    }

    public function compose(View $view)
    {
        $view->with('headlineData', $this->category);
    }
}
