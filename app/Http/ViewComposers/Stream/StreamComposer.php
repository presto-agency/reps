<?php


namespace App\Http\ViewComposers\Stream;


use App\Models\Stream;
use Illuminate\View\View;

class StreamComposer
{
    private $category;

    public function __construct()
    {
        $data = null;

        $data = Stream::with('races:id,title', 'countries:id,flag,name')
            ->orderByDesc('id')
            ->where('approved', 1)
            ->where('active', 1)
            ->first(['id', 'race_id', 'country_id', 'title', 'stream_url_iframe']);

        $this->category = $data;

    }

    public function compose(View $view)
    {
        $view->with('stream', $this->category);
    }

}
