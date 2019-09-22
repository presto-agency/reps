<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModAddKeyUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {

            $table->unsignedBigInteger('country_id')->default(1)->after('email');
            $table->foreign('country_id')->references('id')->on('countries')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('race_id')->default(1)->after('country_id');
            $table->foreign('race_id')->references('id')->on('races')->onDelete('cascade')->onUpdate('cascade');

            $table->string('avatar')->nullable()->after('id');
            $table->integer('rating')->default(0)->after('race_id');
            $table->integer('count_topic')->default(0)->after('rating');
            $table->integer('count_replay')->default(0)->after('count_topic');
            $table->integer('count_picture')->default(0)->after('count_replay');
            $table->integer('count_comment')->default(0)->after('count_picture');
            $table->boolean('ban')->default(false)->after('email_verified_at');
            $table->dateTime('activity_at')->nullable()->after('ban');
            $table->date('birthday')->nullable()->after('activity_at');
            $table->integer('count_negative')->default(0)->after('birthday');
            $table->integer('count_positive')->default(0)->after('count_negative');

            $table->string('homepage')->nullable();
            $table->string('isq')->nullable();
            $table->string('skype')->nullable();
            $table->string('vk_link')->nullable();
            $table->string('fb_link')->nullable();

            $table->ipAddress('last_ip')->nullable();

            $table->integer('count_gosu_replay')->default(0);
            $table->integer('count_comment_forum')->default(0);
            $table->integer('count_comment_gallery')->default(0);
            $table->integer('count_comment_replays')->default(0);

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
            $table->dropForeign(['race_id']);
            $table->dropForeign(['country_id']);
            $table->dropColumn('avatar');
            $table->dropColumn('rating');
            $table->dropColumn('count_topic');
            $table->dropColumn('count_replay');
            $table->dropColumn('count_picture');
            $table->dropColumn('count_comment');
            $table->dropColumn('ban');
            $table->dropColumn('activity_at');
            $table->dropColumn('birthday');
            $table->dropColumn('count_negative');
            $table->dropColumn('count_positive');

            $table->dropColumn('homepage');
            $table->dropColumn('isq');
            $table->dropColumn('skype');
            $table->dropColumn('vk_link');
            $table->dropColumn('fb_link');

            $table->dropColumn('last_ip');

            $table->dropColumn('count_gosu_replay');
            $table->dropColumn('count_comment_forum');
            $table->dropColumn('count_comment_gallery');
            $table->dropColumn('count_comment_replays');


        });
    }
}
