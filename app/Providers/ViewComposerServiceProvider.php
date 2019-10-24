<?php

namespace App\Providers;


use App\Http\ViewComposers\{GetAllReplay,
    ProReplayComposer,
    ProUserReplayComposer,
    TopsComposer,
    DashboardCountComposer,
    FooterComposer,
    HeadlineComposer,
    InterviewVariantAnswerComposer,
    ForumNavigationComposer,
    OnlineStreamListComposer,
    SidebarRightComposer,
    RegistrationComposer,
    UserReplayComposer};
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

        $this->compose('left-side.forum-topics', ForumNavigationComposer::class);
        $this->compose('components.Chat', HeadlineComposer::class);
        $this->compose('content.Page_gameBest', TopsComposer::class);
        $this->compose('components.block-top', TopsComposer::class);
        $this->compose('components.block-top', SidebarRightComposer::class);
        $this->compose('footer.footer', FooterComposer::class);
        $this->compose('modal.registration', RegistrationComposer::class);
        $this->compose('components.streams_list', OnlineStreamListComposer::class);
        $this->compose('content.gocu-replays', ProReplayComposer::class);
        $this->compose('content.user-replays', UserReplayComposer::class);
        $this->compose('components.block-replay', ProUserReplayComposer::class);
    }


    private function compose($views, string $viewComposer)
    {
        $this->app->singleton($viewComposer);
        $this->views->composer($views, $viewComposer);
    }

}
