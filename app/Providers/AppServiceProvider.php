<?php

namespace App\Providers;



use Illuminate\Contracts\View\Factory;
use Illuminate\Support\ServiceProvider;
use App\Observers\UserObserver;
use App\User;
use App\Observers\PollObserver;
use App\Models\Poll;

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

        $userObserve = User::observe(UserObserver::class);
        $pollObserve = Poll::observe(PollObserver::class);




//        $this->views = $viewFactory;
//        dd($viewFactory);
//        $this->compose('*', Poll::class);
//        $this->compose('admin.quick_form', UserComposer::class);
//        $this->compose('admin.quick_refund', UserComposer::class);
    }

    private function compose($views, string $viewComposer)
    {
        $this->app->singleton($viewComposer);
        $this->views->composer($views, $viewComposer);
    }
}
