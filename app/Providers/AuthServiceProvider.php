<?php

namespace App\Providers;

use App\Http\Sections\Tournaments;
use App\Http\Sections\User as UserSection;
use App\Policies\TourneyListPolicy;
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
            UserSection::class => UserSectionPolicy::class,
            Tournaments::class => TourneyListPolicy::class,
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
