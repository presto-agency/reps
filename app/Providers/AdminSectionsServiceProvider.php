<?php

namespace App\Providers;


use AdminNavigation;
use SleepingOwl\Admin\Navigation\Page;
use SleepingOwl\Admin\Contracts\Widgets\WidgetsRegistryInterface;
use SleepingOwl\Admin\Providers\AdminSectionsServiceProvider as ServiceProvider;

class AdminSectionsServiceProvider extends ServiceProvider
{

    protected $widgets = [
        \App\Widgets\DashboardMap::class,
        \App\Widgets\NavigationUserBlock::class,
    ];

    /**
     * @var array
     */
    protected $sections = [
        \App\User::class => 'App\Http\Sections\User',

        \App\Models\Country::class => 'App\Http\Sections\Country',
        \App\Models\InterviewQuestion::class => 'App\Http\Sections\InterviewQuestion',
        \App\Models\Headline::class => 'App\Http\Sections\Headline',
        \App\Models\UserGallery::class => 'App\Http\Sections\UserGallery',
    ];


    /**
     * @param \SleepingOwl\Admin\Admin $admin
     */
    public function boot(\SleepingOwl\Admin\Admin $admin)
    {

        $this->loadViewsFrom(base_path("resources/views/admin"), 'admin');

        $this->registerPolicies('App\\Admin\\Policies\\');

        $this->registerNavigation();

        parent::boot($admin);

        $this->app->call([$this, 'registerViews']);

    }

    private function registerNavigation()
    {



        AdminNavigation::addPage('General')
            ->setPriority(0)
            ->setIcon('fa fa-code')
            ->setId('parent-general');

        AdminNavigation::addPage('Users')
            ->setPriority(100)
            ->setIcon('fas fa-user')
            ->setId('parent-users');


    }

    /**
     * @param WidgetsRegistryInterface $widgetsRegistry
     */
    public function registerViews(WidgetsRegistryInterface $widgetsRegistry)
    {
        foreach ($this->widgets as $widget) {
            $widgetsRegistry->registerWidget($widget);
        }
    }
}
