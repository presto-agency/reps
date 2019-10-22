<?php

namespace App\Providers;


use App\Http\ViewComposers\{AllTopsComposer,
    DashboardCountComposer,
    FooterComposer,
    HeadlineComposer,
    InterviewVariantAnswerComposer,
    ForumNavigationComposer,
    SidebarRightComposer};
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
        $this->compose('content.Page_gameBest', AllTopsComposer::class);
        $this->compose('components.block-top', AllTopsComposer::class);
        $this->compose('components.block-top', SidebarRightComposer::class);
        $this->compose('footer.footer', FooterComposer::class);

    }


    private function compose($views, string $viewComposer)
    {
        $this->app->singleton($viewComposer);
        $this->views->composer($views, $viewComposer);
    }

}
