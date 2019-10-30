<?php


namespace App\Http\ViewComposers;


use App\Models\Stream;
use Illuminate\View\View;

class OnlineStreamListComposer
{
    private $category;

    public function __construct()
    {
        $data = [];

        $getData = Stream::with('races:id,title', 'countries:id,flag')
            ->where('approved', 1)
            ->where('active', 1)
            ->get(['id', 'race_id', 'country_id', 'title', 'stream_url']);
        if (!$getData->isEmpty()) {
            foreach ($getData as $item) {
                $data[] = [
                    'id' => $item->id,
                    'countryFlag25x20' => $item->countries->flag,
                    'racesTitle' => $item->races->title,
                    'streamTitle' => $item->title,
                    'streamUrl' => $item->stream_url,
                ];
            }
        }

        $this->category = $data;

    }

    public function compose(View $view)
    {
        $view->with('streamList', $this->category);
    }

}
