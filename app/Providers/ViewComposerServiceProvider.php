<?php

namespace App\Providers;


use App\Http\ViewComposers\{DashboardCountComposer,
    FooterComposer,
    ForumNavigationComposer,
    HeadlineComposer,
    InterviewVariantAnswerComposer,
    RegistrationComposer,
    ReplaysLSComposer,
    ReplayTypeComposer,
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
        $this->compose('admin.InterviewQuestion.questionClone', InterviewVariantAnswerComposer::class);


//        $this->compose('content.gocu-replays', ProReplayComposer::class);
//        $this->compose('content.user-replays', UserReplayComposer::class);

//        $this->compose('components.block-replay', ProUserReplayComposer::class);
//        $this->compose('components.streams_list', OnlineStreamListComposer::class);
        $this->compose('components.Chat', HeadlineComposer::class);

        /*left-side*/
        $this->compose('left-side.forum-topics', ForumNavigationComposer::class);
        $this->compose('left-side.replays', ReplaysLSComposer::class);
        $this->compose('left-side.replays', ReplayTypeComposer::class);

        /*right-side*/
        $this->compose('components.block-top', LastRegisteredUsersComposer::class);
        $this->compose('components.block-top', Top10Composer::class);

        $this->compose('footer.footer', FooterComposer::class);
        $this->compose('modal.registration', RegistrationComposer::class);


    }


    private function compose($views, string $viewComposer)
    {
        $this->app->singleton($viewComposer);
        $this->views->composer($views, $viewComposer);
    }

}
