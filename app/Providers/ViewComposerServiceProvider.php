<?php

namespace App\Providers;


use App\Http\ViewComposers\{
    DashboardCountComposer,
    FooterComposer,
    HeadlineComposer,
    InterviewVariantAnswerComposer,
    ForumNavigationComposer,
    RegistrationComposer
};
use Illuminate\Contracts\View\Factory;
use Illuminate\Support\ServiceProvider;

class ViewComposerServiceProvider extends ServiceProvider
{

    private $views;

    public function boot(Factory $viewFactory)
    {
//        $this->views = $viewFactory;
//        $this->compose('*', InterviewQuestionObserver::class);
//        $this->compose('admin.quick_form', UserComposer::class);
//        $this->compose('admin.quick_refund', UserComposer::class);

        $this->views = $viewFactory;

        $this->compose('admin.dashboard', DashboardCountComposer::class);
        $this->compose('admin.InterviewQuestion.questionClone', InterviewVariantAnswerComposer::class);
        $this->compose('left-side.forum-topics', ForumNavigationComposer::class);
        $this->compose('components.Chat', HeadlineComposer::class);
        $this->compose('footer.footer', FooterComposer::class);
        $this->compose('modal.registration', RegistrationComposer::class);

    }


    private function compose($views, string $viewComposer)
    {
        $this->app->singleton($viewComposer);

        $this->views->composer($views, $viewComposer);
    }

}
