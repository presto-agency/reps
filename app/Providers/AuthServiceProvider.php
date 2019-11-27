<?php

namespace App\Providers;

use App\Http\Sections\User as UserSection;
use App\Policies\UserPolicy as UserSectionPolicy;
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
