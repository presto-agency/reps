<?php

namespace App\Providers;


use App\Models\Comment;
use App\Models\ForumTopic;
use App\Models\Replay;
use App\Models\UserGallery;
use App\Observers\CommentObserver;
use App\Observers\ForumTopicObserver;
use App\Observers\ReplayObserver;
use App\Observers\UserGalleryObservers;
use Illuminate\Support\ServiceProvider;
use App\Models\InterviewQuestion;
use App\Observers\InterviewQuestionObserver;


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
        ForumTopic::observe(ForumTopicObserver::class);
        Comment::observe(CommentObserver::class);

    }
}
