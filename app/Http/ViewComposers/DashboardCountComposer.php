<?php


namespace App\Http\ViewComposers;

use App\Models\Replay;
use App\User;
use App\Models\ForumTopic;
use Illuminate\View\View;

class DashboardCountComposer
{

    private $category;

    public function __construct()
    {
        $data['users'] = User::count();
        $data['forumTopics'] = ForumTopic::count();

        $getUserReplay = Replay::all(['id', 'user_replay']);
        $data['gosuReplays'] = $getUserReplay->where('user_replay', Replay::REPLAY_PRO)->count();
        $data['userReplays'] = $getUserReplay->where('user_replay', '!=', Replay::REPLAY_PRO)->count();
        $getGosuID = $getUserReplay->where('user_replay', Replay::REPLAY_PRO)->toArray();
        $data['gosuReplaysTypeId'] = reset($getGosuID)['id'];
        $getUserID = $getUserReplay->where('user_replay', '!=', Replay::REPLAY_PRO)->toArray();
        $data['userReplaysTypeId'] = reset($getUserID)['id'];
        $this->category = $data;

    }

    public function compose(View $view)
    {
        $view->with('data', $this->category);
    }
}
