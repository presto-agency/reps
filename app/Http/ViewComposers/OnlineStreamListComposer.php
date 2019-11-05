<?php


namespace App\Http\ViewComposers;


use App\Models\Stream;
use Illuminate\View\View;

class OnlineStreamListComposer
{
    private $category;

    public function __construct()
    {
        $data = null;

        $data = Stream::with('races:id,title', 'countries:id,flag,name')
            ->where('approved', 1)
            ->where('active', 1)
            ->get(['id', 'race_id', 'country_id', 'title', 'stream_url']);

        $this->category = $data;

    }

    public function compose(View $view)
    {
        $view->with('streamList', $this->category);
    }

}
