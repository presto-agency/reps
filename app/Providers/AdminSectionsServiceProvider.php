<?php

namespace App\Providers;

use AdminNavigation;
use AdminSection;

use SleepingOwl\Admin\Providers\AdminSectionsServiceProvider as ServiceProvider;

class AdminSectionsServiceProvider extends ServiceProvider
{



    /**
     * @var array
     */
    protected $sections = [
        \App\Models\Country::class => 'App\Http\Sections\Country',
    ];


    /**
     * @param \SleepingOwl\Admin\Admin $admin
     */
    public function boot(\SleepingOwl\Admin\Admin $admin)
    {

        $this->registerNavigation();

        parent::boot($admin);


    }

    private function registerNavigation()
    {


        AdminNavigation::addPage('General')
            ->setPriority(1000)
            ->setIcon('fa fa-code')
            ->setId('parent-general');


    }
}
