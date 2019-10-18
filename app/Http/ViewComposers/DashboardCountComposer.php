<?php


namespace App\Http\ViewComposers;

use App\User;
use App\Models\ForumTopic;
use App\Models\ReplayType;
use Illuminate\View\View;

class DashboardCountComposer
{

    private $category;

    public function __construct()
    {
        $this->category = collect();

        $data['users'] = User::count();
        $data['forumTopics'] = ForumTopic::count();

        $getUserReplay = ReplayType::withCount('replays')->where('title', 'Пользовательский')->first();
        $data['userReplaysTypeId'] = $getUserReplay->id;
        $data['userReplays'] = $getUserReplay->replays_count;

        $getProReplay = ReplayType::withCount('replays')->where('title', 'Gosu')->first();
        $data['gosuReplaysTypeId'] = $getProReplay->id;
        $data['gosuReplays'] = $getProReplay->replays_count;

        $this->category = $data;

    }

    public function compose(View $view)
    {
        $view->with('data', $this->category);
    }
}
