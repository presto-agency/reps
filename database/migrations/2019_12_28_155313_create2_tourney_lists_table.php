<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Create2TourneyListsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tourney_lists', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id')->index()->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('SET NULL')->onUpdate('cascade');
            $table->string('name', 255);
            $table->string('place', 255);
            $table->string('prize_pool', 255);
            $table->string('rules_link', 255);
            $table->string('vod_link', 255);
            $table->string('logo_link', 255);
            $table->string('password', 12);
            $table->string('maps', 255)->nullable();
            $table->string('all_file', 255)->nullable()->comment('here is an archive with all the tournament files');
            $table->unsignedTinyInteger('status')->index()->comment('watch model for more details');
            $table->unsignedTinyInteger('map_select_type')->index()->comment('watch model for more details');
            $table->tinyInteger('importance')->default(0);
            $table->boolean('visible');
            $table->boolean('ranking');
            $table->dateTime('checkin_time');
            $table->dateTime('start_time');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tourney_lists');
    }

}
