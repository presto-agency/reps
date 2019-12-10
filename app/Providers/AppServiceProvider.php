<?php

namespace App\Providers;


use App\Models\{
    Comment, Country, ForumTopic, Replay, Stream, UserGallery, InterviewQuestion, UserReputation
};
use App\Observers\{
    CommentObserver,
    CountryObserver,
    ForumTopicObserver,
    ReplayObserver,
    StreamObserver,
    UserGalleryObservers,
    UserObserver,
    InterviewQuestionObserver,
    UserReputationObserver
};

use App\User;
use Illuminate\Support\ServiceProvider;


class AppServiceProvider extends ServiceProvider
{

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }


    /**
     * Bootstrap any application services.
     *
     * @return void
     */

    public function boot()
    {
        InterviewQuestion::observe(InterviewQuestionObserver::class);
        UserGallery::observe(UserGalleryObservers::class);
        Replay::observe(ReplayObserver::class);
        Stream::observe(StreamObserver::class);
        ForumTopic::observe(ForumTopicObserver::class);
        Comment::observe(CommentObserver::class);
        User::observe(UserObserver::class);
        Country::observe(CountryObserver::class);
        UserReputation::observe(UserReputationObserver::class);
    }
}
