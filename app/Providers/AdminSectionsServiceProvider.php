<?php

namespace App\Providers;

use AdminNavigation;
use App\Models\Banner;
use App\Models\Bet;
use App\Models\ChatPicture;
use App\Models\ChatSmile;
use App\Models\Country;
use App\Models\Footer;
use App\Models\FooterUrl;
use App\Models\ForumSection;
use App\Models\ForumTopic;
use App\Models\GasTransaction;
use App\Models\Headline;
use App\Models\Help;
use App\Models\InterviewQuestion;
use App\Models\MetaTag;
use App\Models\PublicChat;
use App\Models\Replay;
use App\Models\ReplayMap;
use App\Models\Stream;
use App\Models\Tag;
use App\Models\TourneyList;
use App\Models\TourneyListsMapPool;
use App\Models\TourneyMatch;
use App\Models\TourneyPlayer;
use App\Models\UserActivityLog;
use App\Models\UserGallery;
use App\User;
use App\Widgets\DashboardMap;
use App\Widgets\NavigationUserBlock;
use SleepingOwl\Admin\Admin;
use SleepingOwl\Admin\Contracts\Widgets\WidgetsRegistryInterface;
use SleepingOwl\Admin\Navigation\Page;
use SleepingOwl\Admin\Providers\AdminSectionsServiceProvider as ServiceProvider;

class AdminSectionsServiceProvider extends ServiceProvider
{

    protected $widgets
        = [
            DashboardMap::class,
            NavigationUserBlock::class,
        ];

    /**
     * @var array
     */
    protected $sections
        = [

            Country::class           => 'App\Http\Sections\Country',
            InterviewQuestion::class => 'App\Http\Sections\InterviewQuestion',
            Headline::class          => 'App\Http\Sections\Headline',

            User::class            => 'App\Http\Sections\User',
            UserGallery::class     => 'App\Http\Sections\UserGallery',
            UserActivityLog::class => 'App\Http\Sections\UserActivityLog',

            Stream::class => 'App\Http\Sections\Stream',

            Replay::class       => 'App\Http\Sections\Replay',
            ReplayMap::class    => 'App\Http\Sections\ReplayMap',
            //        \App\Models\ReplayType::class => 'App\Http\Sections\ReplayType',
            ForumTopic::class   => 'App\Http\Sections\ForumTopics',
            ForumSection::class => 'App\Http\Sections\ForumSections',
            ChatSmile::class    => 'App\Http\Sections\ChatSmile',
            ChatPicture::class  => 'App\Http\Sections\ChatPicture',
            PublicChat::class   => 'App\Http\Sections\PublicChat',
            Banner::class       => 'App\Http\Sections\Banner',

            Footer::class    => 'App\Http\Sections\Footer',
            Tag::class       => 'App\Http\Sections\Tag',
            FooterUrl::class => 'App\Http\Sections\FooterUrl',
            Help::class      => 'App\Http\Sections\Help',

            TourneyList::class         => 'App\Http\Sections\Tournaments',
            TourneyListsMapPool::class => 'App\Http\Sections\TournamentsMapPool',
            TourneyPlayer::class       => 'App\Http\Sections\TournamentsPlayer',
            TourneyMatch::class        => 'App\Http\Sections\TournamentsMatches',
            GasTransaction::class      => 'App\Http\Sections\GasTransaction',
            Bet::class                 => 'App\Http\Sections\Bet',

            MetaTag::class => 'App\Http\Sections\MetaTags',
        ];


    /**
     * @param  \SleepingOwl\Admin\Admin  $admin
     */
    public function boot(Admin $admin)
    {
        $this->loadViewsFrom(base_path("resources/views/admin"), 'admin');

        $this->registerNavigation();

        parent::boot($admin);

        $this->app->call([$this, 'registerViews']);
    }

    private function registerNavigation()
    {
        AdminNavigation::setFromArray([
            [
                'title'    => 'Общие',
                'icon'     => 'fas fa-crow',
                'priority' => 1,
                'pages'    => [
                    (new Page(Country::class))->setPriority(1),
                    (new Page(InterviewQuestion::class))->setPriority(2),
                    (new Page(Headline::class))->setPriority(3),
                ],
            ],
        ]);

        AdminNavigation::setFromArray([
            [
                'title'    => 'Пользователи',
                'icon'     => 'fas fa-users',
                'priority' => 2,
                'pages'    => [
                    (new Page(User::class))->setPriority(1),
                    (new Page(UserGallery::class))->setPriority(2),
                    (new Page(GasTransaction::class))->setPriority(3),
                    (new Page(Bet::class))->setPriority(4),
                    (new Page(UserActivityLog::class))->setPriority(5),
                ],
            ],
        ]);

        /*Insert Section Stream from Section */

        AdminNavigation::setFromArray([
            [
                'title'    => 'Форум',
                'icon'     => 'fas fa-user',
                'priority' => 4,
                'pages'    => [
                    (new Page(ForumSection::class))->setPriority(1),
                    (new Page(ForumTopic::class))->setPriority(2),
                ],
            ],
        ]);

        AdminNavigation::setFromArray([
            [
                'title'    => 'Replays',
                'icon'     => 'fas fa-play-circle',
                'priority' => 5,
                'pages'    => [
                    (new Page(Replay::class))->setPriority(1),
                    (new Page(ReplayMap::class))->setPriority(2),
                    //                    (new Page(\App\Models\ReplayType::class))->setPriority(3),
                ],
            ],
        ]);

        AdminNavigation::setFromArray([
            [
                'title'    => 'Болтаем',
                'icon'     => 'fas fa-comments',
                'priority' => 6,
                'pages'    => [
                    (new Page(PublicChat::class))->setPriority(1),
                    (new Page(ChatSmile::class))->setPriority(2),
                    (new Page(ChatPicture::class))->setPriority(3),
                    (new Page(Tag::class))->setPriority(4),
                    (new Page(Help::class))->setPriority(5),
                ],
            ],
        ]);
        AdminNavigation::setFromArray([
            [
                'title'    => 'Турниры',
                'icon'     => 'fas fa-window-minimize',
                'priority' => 7,
                'pages'    => [
                    (new Page(TourneyList::class))->setPriority(1),
                    (new Page(TourneyListsMapPool::class))->setPriority(2),
                    (new Page(TourneyPlayer::class))->setPriority(3),
                    (new Page(TourneyMatch::class))->setPriority(4),
                ],
            ],
        ]);
        AdminNavigation::setFromArray([
            [
                'title'    => 'Footer',
                'icon'     => 'fas fa-window-minimize',
                'priority' => 8,
                'pages'    => [
                    (new Page(Footer::class))->setPriority(1),
                    (new Page(FooterUrl::class))->setPriority(2),
                ],
            ],
        ]);
    }

    /**
     * @param  WidgetsRegistryInterface  $widgetsRegistry
     */
    public function registerViews(WidgetsRegistryInterface $widgetsRegistry)
    {
        foreach ($this->widgets as $widget) {
            $widgetsRegistry->registerWidget($widget);
        }
    }

}
