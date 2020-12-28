<?php

// Default check access logic
// AdminNavigation::setAccessLogic(function(Page $page) {
// 	   return auth()->user()->isSuperAdmin();
// });
//
// AdminNavigation::addPage(\App\User::class)->setTitle('test')->setPages(function(Page $page) {
// 	  $page
//		  ->addPage()
//	  	  ->setTitle('Dashboard')
//		  ->setUrl(route('admin.dashboard'))
//		  ->setPriority(100);
//
//	  $page->addPage(\App\User::class);
// });
//
// // or
//
// AdminSection::addMenuPage(\App\User::class)

use App\Models\MetaTag;
use SleepingOwl\Admin\Navigation\Page;

return [

    [
        'title' => 'Translation Manager',
        'icon'  => 'fa fa-language',
        'url'   => url('admin/translations'),
    ],
    (new Page(MetaTag::class))
        ->setTitle('MetaTag')
        ->setPriority(9)
        ->setIcon('fas fa-hashtag'),
    [
        'title' => 'PhP info',
        'icon'  => 'fab fa-php',
        'url'   => url('admin/phpinfo'),
    ],
    [
        'title' => 'Logs',
        'icon'  => 'fas fa-info-circle',
        'url'   => url('admin/logs'),
    ],
];
