<?php

namespace App\Providers;


use App\Admin\Policies\UserSectionModelPolicy;
//use App\Policies\UserModelPolicy;
use App\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;


class AuthServiceProvider extends ServiceProvider
{

    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies
        = [
//            User::class => UserSectionModelPolicy::class,
//            User::class => UserModelPolicy::class,
        ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */

    public function boot()
    {
        $this->registerPolicies();

    }

}
