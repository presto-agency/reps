<?php

namespace App\Providers;


use App\Http\ViewComposers\{admin\DashboardCountComposer,
    admin\InterviewVariantAnswerComposer,
    FixingTopicsComposer,
    Footer\FooterComposer,
    ForumNavigationComposer,
    GlobalView\GlobalComposer,
    HeadlineComposer,
    LeftOrRightSide\InterviewComposer,
    LeftSide\LastNewsComposer,
    LeftSide\LastReplaysComposer,
    RightSide\LastRegisteredUsersComposer,
    RightSide\LastReplayComposer,
    RightSide\Top10KgPtsComposer,
    Smiles,
    Stream\OnlineStreamListComposer
};
use Illuminate\Contracts\View\Factory;
use Illuminate\Support\ServiceProvider;

class ViewComposerServiceProvider extends ServiceProvider
{

    private $views;

    public function boot(Factory $viewFactory)
    {
        $this->views = $viewFactory;

        $this->compose('*', GlobalComposer::class);

        $this->compose('admin.dashboard', DashboardCountComposer::class);
        $this->compose('admin.interviewQuestion.answers', InterviewVariantAnswerComposer::class);

        /*header*/
        $this->compose('home.components.chat.index', HeadlineComposer::class);
        $this->compose('home.components.chat.components.streams-list', OnlineStreamListComposer::class);

        /*left-side*/
        $this->compose('left-side.forum-topics', ForumNavigationComposer::class);
        $this->compose('left-side.last-replays', LastReplaysComposer::class);
        $this->compose('left-side.last-news', LastNewsComposer::class);
        /*right-side*/
        $this->compose('right-side.index', LastRegisteredUsersComposer::class);
        $this->compose('right-side.index', Top10KgPtsComposer::class);
        $this->compose('right-side.components.last-replay', LastReplayComposer::class);
        /*left-or-right-side*/
        $this->compose('components.interview', InterviewComposer::class);


        $this->compose('layouts.components.footer.index', FooterComposer::class);

        $this->compose('layouts.app', Smiles::class);

        $this->compose('news.components.index', FixingTopicsComposer::class);

    }


    private function compose($views, string $viewComposer)
    {
        $this->app->singleton($viewComposer);
        $this->views->composer($views, $viewComposer);
    }

}
