<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'count_topic')) {
                $table->dropColumn('count_topic');
            }
            if (Schema::hasColumn('users', 'count_replay')) {
                $table->dropColumn('count_replay');
            }
            if (Schema::hasColumn('users', 'count_picture')) {
                $table->dropColumn('count_picture');
            }
            if (Schema::hasColumn('users', 'count_comment')) {
                $table->dropColumn('count_comment');
            }
            if (Schema::hasColumn('users', 'count_gosu_replay')) {
                $table->dropColumn('count_gosu_replay');
            }
            if (Schema::hasColumn('users', 'count_comment_forum')) {
                $table->dropColumn('count_comment_forum');
            }
            if (Schema::hasColumn('users', 'count_comment_gallery')) {
                $table->dropColumn('count_comment_gallery');
            }
            if (Schema::hasColumn('users', 'count_comment_replays')) {
                $table->dropColumn('count_comment_replays');
            }
            if (Schema::hasColumn('users', 'points')) {
                $table->dropColumn('points');
            }

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {

            if (!Schema::hasColumn('users', 'count_topic')) {
                $table->integer('count_topic');
            }
            if (!Schema::hasColumn('users', 'count_replay')) {
                $table->integer('count_replay');
            }
            if (!Schema::hasColumn('users', 'count_picture')) {
                $table->integer('count_picture');
            }
            if (!Schema::hasColumn('users', 'count_comment')) {
                $table->integer('count_comment');
            }
            if (!Schema::hasColumn('users', 'count_gosu_replay')) {
                $table->integer('count_gosu_replay');
            }
            if (!Schema::hasColumn('users', 'count_comment_forum')) {
                $table->integer('count_comment_forum');
            }
            if (!Schema::hasColumn('users', 'count_comment_gallery')) {
                $table->integer('count_comment_gallery');
            }
            if (!Schema::hasColumn('users', 'count_comment_replays')) {
                $table->integer('count_comment_replays');
            }
            if (!Schema::hasColumn('users', 'points')) {
                $table->integer('points');
            }
        });
    }
}
