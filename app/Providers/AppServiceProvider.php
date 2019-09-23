<?php

namespace App\Providers;



use Illuminate\Contracts\View\Factory;
use Illuminate\Support\ServiceProvider;

use App\User;
use App\Models\InterviewQuestion;

use App\Observers\UserObserver;
use App\Observers\InterviewQuestionObserver;



class AppServiceProvider extends ServiceProvider
{

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    private $views;

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
//Factory $viewFactory
    public function boot()
    {

//        $userObserve = User::observe(UserObserver::class);
        $interviewQuestion = InterviewQuestion::observe(InterviewQuestionObserver::class);




//        $this->views = $viewFactory;
//        dd($viewFactory);
//        $this->compose('*', InterviewQuestionObserver::class);
//        $this->compose('admin.quick_form', UserComposer::class);
//        $this->compose('admin.quick_refund', UserComposer::class);
    }

    private function compose($views, string $viewComposer)
    {
        $this->app->singleton($viewComposer);
        $this->views->composer($views, $viewComposer);
    }
}
