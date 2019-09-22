<?php

namespace App\Providers;


use App\Http\ViewComposers\UserComposer;
use Illuminate\Contracts\View\Factory;
use Illuminate\Support\ServiceProvider;

//use App\Http\ViewComposers\SettingComposer;


class ViewComposerServiceProvider extends ServiceProvider
{

    private $views;

    public function boot(Factory $viewFactory)
    {

        $this->views = $viewFactory;

//    $this->compose('*', SettingComposer::class);

        $this->compose('admin.dashboard', UserComposer::class);


    }


    private function compose($views, string $viewComposer)
    {
        $this->app->singleton($viewComposer);

        $this->views->composer($views, $viewComposer);
    }

}
