<?php

namespace App\Providers;


use App\Http\ViewComposers\{DashboardCountComposer,
    FooterComposer,
    ForumNavigationComposer,
    HeadlineComposer,
    InterviewVariantAnswerComposer,
    LeftSide\ReplaysNavigationComposer,
    RegistrationComposer,
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
//        $this->compose('components.streams_list', OnlineStreamListComposer::class);
        $this->compose('components.Chat', HeadlineComposer::class);
        /*left-side*/
        $this->compose('left-side.forum-topics', ForumNavigationComposer::class);
        $this->compose('left-side.replays-navigation', ReplaysNavigationComposer::class);
        /*right-side*/
        $this->compose('right-side.block-top', LastRegisteredUsersComposer::class);
        $this->compose('right-side.block-top', Top10Composer::class);

        $this->compose('footer.footer', FooterComposer::class);
        $this->compose('modal.registration', RegistrationComposer::class);

    }


    private function compose($views, string $viewComposer)
    {
        $this->app->singleton($viewComposer);
        $this->views->composer($views, $viewComposer);
    }

}
