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
         * 2.This process uses the following tables:
         * reps.(<replay_maps>)
         * loc.(<replay_maps>).
         */
                $this->call(TransferReplayMaps::class);

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
                $this->call(TransferTournamentsList::class);

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
                $this->call(TransferTournamentsMatches::class);

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
                $this->call(TransferTournamentsPlayers::class);

        /**
         *
         * Transfer data from reps reps.<countries> in loc.<countries>
         *
         * Attention!!!
         *
         * 1.The table loc.<countries> will be cleared.
         * 2.This process uses the following tables:
         * reps.(<countries>)
         * loc.(<countries>).
         */
                $this->call(TransferCountries::class);

        /**
         *
         * Transfer data from reps reps.<user_activity_logs> in loc.<user_activity_logs>
         *
         * Attention!!!
         *
         * 1.The table loc.<user_activity_logs> will be cleared.
         * 2.This process uses the following tables:
         * reps.(<user_activity_logs>)
         * loc.(<user_activity_logs>).
         */
                $this->call(TransferUserActivityLogs::class);

        /**
         *
         * Transfer data from reps reps.<replays> in loc.<replays>
         *
         * Attention!!!
         *
         * 1.The table loc.<replays> will be cleared.
         * 2.This process uses the following tables:
         * reps.(<replays>,<files>)
         * loc.(<replays>).
         */
                $this->call(TransferReplays::class);

        /**
         *
         * Transfer data from reps reps.<streams> in loc.<streams>
         *
         * Attention!!!
         *
         * 1.The table loc.<streams> will be cleared.
         * 2.This process uses the following tables:
         * reps.(<streams>)
         * loc.(<streams>).
         */
        $this->call(TransferStreams::class);
        $this->call(SeederStreams::class);
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
                $this->call(TransferForumSections::class);

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

        /**
         *
         * Transfer data from reps reps.<users> in loc.<users>
         *
         * Attention!!!
         *
         * 1.The table loc.<forum_topics> will be cleared.
         * 2.This process uses the following tables:
         * reps.(<users>,<files>)
         * loc.(<users>).
         */
                $this->call(TransferUsers::class);
                $this->call(SeederSuperAdmin::class);

        /**
         *
         * Transfer data from reps reps.<comments> in loc.<comments>
         *
         * Attention!!!
         *
         * 1.The table loc.<forum_topics> will be cleared.
         * 2.This process uses the following tables:
         * reps.(<comments>)
         * loc.(<comments>).
         */
//                $this->call(TransferComments::class);

        /**
         *
         * Transfer data from reps reps.<interview_questions> in loc.<interview_questions>
         * Transfer data from reps reps.<interview_user_answers> in loc.<interview_user_answers>
         * Transfer data from reps reps.<interview_variants_answers> in loc.<interview_variants_answers>
         *
         * Attention!!!
         *
         * 1.The table loc.<interview_questions> will be cleared.
         * 2.The table loc.<interview_user_answers> will be cleared.
         * 3.The table loc.<interview_variants_answers> will be cleared.
         * 4.This process uses the following tables:
         * reps.(<interview_questions>,<interview_user_answers>,<interview_variants_answers>)
         * loc.(<interview_questions>,<interview_user_answers>,<interview_variants_answers>).
         */
                $this->call(TransferInterview::class);
        /**
         *
         * Transfer data from reps reps.<user_reputations> in loc.<user_reputations>
         *
         * Attention!!!
         *
         * 1.The table loc.<user_reputations> will be cleared.
         * 2.This process uses the following tables:
         * reps.(<user_reputations>)
         * loc.(<user_reputations>).
         */
                $this->call(TransferUserReputations::class);

        /**
         *
         * Transfer data from reps reps.<user_galleries> in loc
         * .<user_galleries>
         *
         * Attention!!!
         *
         * 1.The table loc.<user_reputations> will be cleared.
         * 2.This process uses the following tables:
         * reps.(<user_galleries>)
         * loc.(<user_galleries>).
         */
                $this->call(TransferUserGalleries::class);
    }

}
