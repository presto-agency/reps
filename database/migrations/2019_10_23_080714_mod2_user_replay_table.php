<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Mod2UserReplayTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('replays', function (Blueprint $table) {
            $table->renameColumn('comments_count', 'user_replay');
        });
        Schema::table('replays', function (Blueprint $table) {
            $table->integer('user_replay')->default(1)->change();
        });

        Schema::table('replay_types', function (Blueprint $table) {
            $table->string('name')->after('id');
        });

        Artisan::call('db:seed', array('--class' => 'SeederReplayTypes'));

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('replays', function (Blueprint $table) {
            $table->renameColumn('user_replay', 'comments_count');
        });
        Schema::table('replays', function (Blueprint $table) {
            $table->integer('comments_count')->default(0)->change();
        });
    }
}
