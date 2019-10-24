<?php

namespace App\Providers;

use AdminNavigation;
use SleepingOwl\Admin\Contracts\Widgets\WidgetsRegistryInterface;
use SleepingOwl\Admin\Navigation\Page;
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
        \App\Models\InterviewQuestion::class => 'App\Http\Sections\InterviewQuestion',
        \App\Models\Headline::class => 'App\Http\Sections\Headline',

        \App\User::class => 'App\Http\Sections\User',
        \App\Models\UserGallery::class => 'App\Http\Sections\UserGallery',
        \App\Models\UserActivityLog::class => 'App\Http\Sections\UserActivityLog',

        \App\Models\Stream::class => 'App\Http\Sections\Stream',

        \App\Models\Replay::class => 'App\Http\Sections\Replay',
        \App\Models\ReplayMap::class => 'App\Http\Sections\ReplayMap',
//        \App\Models\ReplayType::class => 'App\Http\Sections\ReplayType',
        \App\Models\ForumTopic::class => 'App\Http\Sections\ForumTopics',
        \App\Models\ForumSection::class => 'App\Http\Sections\ForumSections',
        \App\Models\ChatSmile::class => 'App\Http\Sections\ChatSmile',
        \App\Models\ChatPicture::class => 'App\Http\Sections\ChatPicture',
        \App\Models\PublicChat::class => 'App\Http\Sections\PublicChat',
        \App\Models\Banner::class => 'App\Http\Sections\Banner',

        \App\Models\Footer::class => 'App\Http\Sections\Footer',
        \App\Models\Tag::class => 'App\Http\Sections\Tag',
        \App\Models\FooterUrl::class => 'App\Http\Sections\FooterUrl',
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
        AdminNavigation::setFromArray([
            [
                'title' => 'Общие',
                'icon' => 'fas fa-crow',
                'priority' => 1,
                'pages' => [
                    (new Page(\App\Models\Country::class))->setPriority(1),
                    (new Page(\App\Models\InterviewQuestion::class))->setPriority(2),
                    (new Page(\App\Models\Headline::class))->setPriority(3),
                ]
            ]
        ]);

        AdminNavigation::setFromArray([
            [
                'title' => 'Пользователи',
                'icon' => 'fas fa-users',
                'priority' => 2,
                'pages' => [
                    (new Page(\App\User::class))->setPriority(1),
                    (new Page(\App\Models\UserGallery::class))->setPriority(2),
                    (new Page(\App\Models\UserActivityLog::class))->setPriority(3),
                ]
            ]
        ]);

        /*Insert Section Stream from Section */

        AdminNavigation::setFromArray([
            [
                'title' => 'ФОРУМ',
                'icon' => 'fas fa-user',
                'priority' => 1,
                'pages' => [
                    (new Page(\App\Models\ForumSection::class))->setPriority(1),
                    (new Page(\App\Models\ForumTopic::class))->setPriority(2),
                ]
            ]
        ]);

        AdminNavigation::setFromArray([
            [
                'title' => 'Replays',
                'icon' => 'fas fa-play-circle',
                'priority' => 5,
                'pages' => [
                    (new Page(\App\Models\Replay::class))->setPriority(1),
                    (new Page(\App\Models\ReplayMap::class))->setPriority(2),
//                    (new Page(\App\Models\ReplayType::class))->setPriority(3),
                ]
            ]
        ]);

        AdminNavigation::setFromArray([
            [
                'title' => 'Болтаем',
                'icon' => 'fas fa-comments',
                'priority' => 6,
                'pages' => [
                    (new Page(\App\Models\PublicChat::class))->setPriority(1),
                    (new Page(\App\Models\ChatSmile::class))->setPriority(2),
                    (new Page(\App\Models\ChatPicture::class))->setPriority(3),
                    (new Page(\App\Models\Tag::class))->setPriority(4),
                ]
            ]
        ]);

        AdminNavigation::setFromArray([
            [
                'title' => 'Footer',
                'icon' => 'fas fa-window-minimize',
                'priority' => 7,
                'pages' => [
                    (new Page(\App\Models\Footer::class))->setPriority(1),
                    (new Page(\App\Models\FooterUrl::class))->setPriority(2),
                ]
            ]
        ]);

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
