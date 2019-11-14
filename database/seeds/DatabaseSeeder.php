<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        /**
         *
         * Transfer data from reps.<replay_maps> in loc.<replay_maps>.
         *
         * Attention!!!
         *
         * 1.The table loc.<replay_maps> will be cleared.
         * 2.In this process, all keys and their fields will be changed in the loc.(<replays>) table.
         * 3.This process uses the following tables:
         * reps.(<replay_maps>)
         * loc.(<replays>,<replay_maps>).
         */
//        $this->call(TransferReplayMaps::class);

        /**
         *
         * Transfer data from reps.<tourney_lists> in loc.<tourney_lists>.
         *
         * Attention!!!
         *
         * 1.The table loc.<tourney_lists> will be cleared.
         * 2.This process uses the following tables:
         * reps.(<tourney_lists>,<files>)
         * loc.(<tourney_lists>).
         */
//        $this->call(TransferTournamentsList::class);

        /**
         *
         * Transfer data from reps.<tourney_matches> in loc.<tourney_matches>
         *
         * Attention!!!
         *
         * 1.The table loc.<tourney_matches> will be cleared.
         * 2.This process uses the following tables:
         * reps.(<tourney_matches>,<files>)
         * loc.(<tourney_matches>).
         */
//        $this->call(TransferTournamentsMatches::class);

        /**
         *
         * Transfer data from reps reps.<tourney_players> in loc.<tourney_players>
         *
         * Attention!!!
         *
         * 1.The table loc.<tourney_players> will be cleared.
         * 2.This process uses the following tables:
         * reps.(<tourney_players>)
         * loc.(<tourney_players>).
         */
//        $this->call(TransferTournamentsPlayers::class);

        /**
         *
         * Transfer data from reps reps.<countries> in loc.<countries>
         *
         * Attention!!!
         *
         * 1.The table loc.<countries> will be cleared.
         * 2.In this process, all keys and their fields will be changed in the loc.(<users>,<streams>) table.
         * 3.This process uses the following tables:
         * reps.(<countries>)
         * loc.(<countries>,<replays>,<users>,<streams>).
         */
//        $this->call(TransferCountries::class);


        /**
         *
         * Transfer data from reps reps.<user_activity_logs> in loc.<user_activity_logs>
         *
         * Attention!!!
         *
         * 1.The table loc.<user_activity_logs> will be cleared.
         * 2.In this process, all keys and their fields will be changed in the loc.(<user_activity_logs>) table.
         * 3.This process uses the following tables:
         * reps.(<user_activity_logs>)
         * loc.(<user_activity_logs>,<users>).
         */
//        $this->call(TransferUserActivityLogs::class);

        /**
         *
         * Transfer data from reps reps.<replays> in loc.<replays>
         *
         * Attention!!!
         *
         * 1.The table loc.<replays> will be cleared.
         * 2.This process uses the following tables:
         * reps.(<replays>,<files>)
         * loc.(<replays>,<races>).
         */
//        $this->call(TransferReplays::class);

        /**
         *
         * Transfer data from reps reps.<streams> in loc.<streams>
         *
         * Attention!!!
         *
         * 1.The table loc.<streams> will be cleared.
         * 2.In this process, all keys and their fields will be changed in the loc.(<streams>) table.
         * 3.This process uses the following tables:
         * reps.(<streams>)
         * loc.(<streams>,<races>).
         */
//        $this->call(TransferStreams::class);

        /**
         *
         * Transfer data from reps reps.<forum_sections> in loc.<forum_sections>
         *
         * Attention!!!
         *
         * 1.The table loc.<streams> will be cleared.
         * 2.This process uses the following tables:
         * reps.(<forum_sections>)
         * loc.(<forum_sections>).
         */
//        $this->call(TransferForumSections::class);

        /**
         *
         * Transfer data from reps reps.<forum_topics> in loc.<forum_topics>
         *
         * Attention!!!
         *
         * 1.The table loc.<forum_topics> will be cleared.
         * 2.This process uses the following tables:
         * reps.(<forum_topics>,<files>)
         * loc.(<forum_topics>).
         */
        $this->call(TransferForumTopics::class);


//        $this->call(SeederSuperAdmin::class);
    }
}
