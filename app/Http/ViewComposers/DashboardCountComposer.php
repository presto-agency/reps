<?php


namespace App\Http\ViewComposers;

use App\Models\ReplayType;
use Illuminate\View\View;

class DashboardCountComposer
{

    private $category;

    public function __construct()
    {
        $this->category = collect();

        $data['users'] = \DB::table('users')->select('id')->count();
        $data['forumTopics'] = \DB::table('forum_topics')->select('id')->count();
        $data['userReplaysTypeId'] = $userReplaysId = ReplayType::select('id')->where('title', 'Пользовательский')->first()->id;
        $data['userReplays'] = \DB::table('replays')->select('id', 'type_id')->where('type_id', $userReplaysId)->count();
        $data['gosuReplaysTypeId'] = $gosuReplaysId = ReplayType::select('id')->where('title', 'Gosu')->first()->id;
        $data['gosuReplays'] = \DB::table('replays')->select('id', 'type_id')->where('type_id', $gosuReplaysId)->count();


        $this->category = $data;

    }

    public function compose(View $view)
    {

        $view->with('data', $this->category);
    }
}
