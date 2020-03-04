<?php

namespace App\Providers;


use App\Models\{
    Comment,
    Country,
    ForumTopic,
    GasTransaction,
    InterviewQuestion,
    PublicChat,
    Replay,
    Stream,
    TourneyList,
    TourneyMatch,
    UserGallery,
    UserReputation
};
use App\Observers\{
    CommentObserver,
    CountryObserver,
    ForumTopicObserver,
    GasTransactionObserver,
    InterviewQuestionObserver,
    PublicChatObserver,
    ReplayObserver,
    StreamObserver,
    TourneyListObserver,
    TourneyMatchObserver,
    UserGalleryObservers,
    UserObserver,
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
        GasTransaction::observe(GasTransactionObserver::class);
        PublicChat::observe(PublicChatObserver::class);
        /**
         * Tournaments
         */
        TourneyList::observe(TourneyListObserver::class);
        TourneyMatch::observe(TourneyMatchObserver::class);

        /**
         * Re-Open assets
         */
        $assetsFile = resource_path().'/assets/admin/assets.php';
        if (file_exists($assetsFile)) {
            include $assetsFile;
        }
    }

}
