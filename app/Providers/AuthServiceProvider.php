<?php

namespace App\Providers;

use App\Http\Sections\{Tournaments, TournamentsMapPool, TournamentsMatches, TournamentsPlayer, User as UserSection};
use App\Policies\{TourneyListPolicy,
    TourneyMapPollPolicy,
    TourneyMatchPolicy,
    TourneyPlayersPolicy,
    UserPolicy as UserSectionPolicy};
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
            TournamentsMapPool::class => TourneyMapPollPolicy::class,
            TournamentsPlayer::class => TourneyPlayersPolicy::class,
            TournamentsMatches::class => TourneyMatchPolicy::class,
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
