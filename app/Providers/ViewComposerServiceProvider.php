<?php

namespace App\Providers;


use App\Http\ViewComposers\DashboardCountComposer;
use App\Http\ViewComposers\InterviewVariantAnswerComposer;
use Illuminate\Contracts\View\Factory;
use Illuminate\Support\ServiceProvider;

class ViewComposerServiceProvider extends ServiceProvider
{

    private $views;

    public function boot(Factory $viewFactory)
    {

        $this->views = $viewFactory;

//        $this->views = $viewFactory;
//        $this->compose('*', InterviewQuestionObserver::class);
//        $this->compose('admin.quick_form', UserComposer::class);
//        $this->compose('admin.quick_refund', UserComposer::class);

        $this->compose('admin.dashboard', DashboardCountComposer::class);
        $this->compose('admin.InterviewQuestion.questionClone', InterviewVariantAnswerComposer::class);


    }


    private function compose($views, string $viewComposer)
    {
        $this->app->singleton($viewComposer);

        $this->views->composer($views, $viewComposer);
    }

}
