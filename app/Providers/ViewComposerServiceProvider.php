<?php

namespace App\Providers;


use App\Http\ViewComposers\{admin\DashboardCountComposer,
    Footer\FooterComposer,
    ForumNavigationComposer,
    HeadlineComposer,
    admin\InterviewVariantAnswerComposer,
    LeftOrRightSide\LastNewsOrReplayComposer,
    LeftOrRightSide\VoteComposer,
    LeftSide\ReplaysNavigationComposer,
    LeftSide\ReplaysShowInHomeComposer,
    Registration\RegistrationComposer,
    RightSide\LastRegisteredUsersComposer,
    RightSide\Top10Composer};
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
//        $this->compose('components.streams_list', OnlineStreamListComposer::class);
        $this->compose('components.Chat', HeadlineComposer::class);
        /*left-side*/
        $this->compose('left-side.forum-topics', ForumNavigationComposer::class);
        $this->compose('left-side.replays-navigation', ReplaysNavigationComposer::class);
        $this->compose('left-side.replays-show-in-home', ReplaysShowInHomeComposer::class);
        /*right-side*/
        $this->compose('right-side.index', LastRegisteredUsersComposer::class);
        $this->compose('right-side.index', Top10Composer::class);
        $this->compose('components.block-last-5-news-or-replay', LastNewsOrReplayComposer::class);
        $this->compose('components.vote', VoteComposer::class);

        $this->compose('modal.registration', RegistrationComposer::class);

        $this->compose('footer.index', FooterComposer::class);

    }


    private function compose($views, string $viewComposer)
    {
        $this->app->singleton($viewComposer);
        $this->views->composer($views, $viewComposer);
    }

}
