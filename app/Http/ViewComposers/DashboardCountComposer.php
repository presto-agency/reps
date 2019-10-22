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

        $getUserReplay = ReplayType::withCount('replays')->where('title', 'Пользовательский');
        if (!(empty($getUserReplay))) {
            $data['userReplaysTypeId'] = $getUserReplay->value('id');
            $data['userReplays'] = $getUserReplay->value('replays_count');
        }

        $getProReplay = ReplayType::withCount('replays')->where('title', 'Профессиональный');
        if (!(empty($getProReplay))) {
            $data['gosuReplaysTypeId'] = $getProReplay->value('id');
            $data['gosuReplays'] = $getProReplay->value('replays_count');
        }
        $this->category = $data;

    }

    public function compose(View $view)
    {
        $view->with('data', $this->category);
    }
}
