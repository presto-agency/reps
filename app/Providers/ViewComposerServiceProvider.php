<?php

namespace App\Providers;


use App\Http\ViewComposers\{admin\DashboardCountComposer,
    Footer\FooterComposer,
    ForumNavigationComposer,
    HeadlineComposer,
    admin\InterviewVariantAnswerComposer,
    LeftOrRightSide\InterviewComposer,
    LeftSide\LastNewsComposer,
    LeftSide\NavigationReplaysComposer,
    LeftSide\LastUserProReplaysComposer,
    OnlineStreamListComposer,
    Registration\RegistrationComposer,
    RightSide\LastRegisteredUsersComposer,
    RightSide\Top10KgPtsComposer,
    RightSide\LastReplayComposer};
use Illuminate\Contracts\View\Factory;
use Illuminate\Support\ServiceProvider;

class ViewComposerServiceProvider extends ServiceProvider
{

    private $views;

    public function boot(Factory $viewFactory)
    {

//  toAllViews      $this->compose('*', InterviewQuestionObserver::class);

        $this->views = $viewFactory;

        $this->compose('admin.dashboard', DashboardCountComposer::class);
        $this->compose('admin.interviewQuestion.answers', InterviewVariantAnswerComposer::class);
        /*header*/
        $this->compose('home.components.chat.index', HeadlineComposer::class);
        $this->compose('home.components.chat.components.streams-list', OnlineStreamListComposer::class);
        /*left-side*/
        $this->compose('left-side.forum-topics', ForumNavigationComposer::class);
        $this->compose('left-side.navigation-replays', NavigationReplaysComposer::class);
        $this->compose('left-side.last-replays', LastUserProReplaysComposer::class);
        $this->compose('left-side.last-news', LastNewsComposer::class);
        /*right-side*/

        $this->compose('right-side.index', LastRegisteredUsersComposer::class);
        $this->compose('right-side.index', Top10KgPtsComposer::class);
        $this->compose('right-side.components.last-replay', LastReplayComposer::class);
        /*left-or-right-side*/
        $this->compose('components.interview', InterviewComposer::class);
        /*modal*/
        $this->compose('modal.registration', RegistrationComposer::class);
        /*footer*/
        $this->compose('layouts.components.footer.index', FooterComposer::class);

    }


    private function compose($views, string $viewComposer)
    {
        $this->app->singleton($viewComposer);
        $this->views->composer($views, $viewComposer);
    }

}
