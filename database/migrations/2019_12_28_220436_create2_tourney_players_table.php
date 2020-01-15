<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Create2TourneyPlayersTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tourney_players', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('tourney_id')->index()->nullable();
            $table->foreign('tourney_id')->references('id')->on('tourney_lists')
                ->onDelete('SET NULL')->onUpdate('cascade');
            $table->unsignedBigInteger('user_id')->index()->nullable();
            $table->foreign('user_id')->references('id')->on('users')
                ->onDelete('SET NULL')->onUpdate('cascade');
            $table->boolean('check')->default(false);
            $table->boolean('ban')->default(false);
            $table->string('description');
            $table->unsignedTinyInteger('place_result')->nullable();
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
        //
    }

}
