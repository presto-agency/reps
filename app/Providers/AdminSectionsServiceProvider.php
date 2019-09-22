<?php

namespace App\Providers;


use AdminNavigation;
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
        \App\Models\Country::class => 'App\Http\Sections\Country',
        \App\Models\Poll::class => 'App\Http\Sections\Poll',
        \App\User::class => 'App\Http\Sections\User',
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
            ->setPriority(100)
            ->setIcon('fa fa-code')
            ->setId('parent-general');
        AdminNavigation::addPage('Users')
            ->setPriority(200)
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
