<?php

namespace App\Providers;


use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{

    protected $widgets = [
        \App\Widgets\DashboardMap::class
    ];


    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Регистрация виджетов в реестре
        /** @var WidgetsRegistryInterface $widgetsRegistry */
        $widgetsRegistry = $this->app[\SleepingOwl\Admin\Contracts\Widgets\WidgetsRegistryInterface::class];

        foreach ($this->widgets as $widget) {
            $widgetsRegistry->registerWidget($widget);
        }
    }
}
