<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Create2TourneyMatchesTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tourney_matches', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('tourney_id')->nullable()->index();
            $table->foreign('tourney_id')->references('id')->on('tourney_lists')
                ->onDelete('SET NULL')->onUpdate('cascade');
            $table->unsignedBigInteger('player1_id')->nullable()->index();
            $table->foreign('player1_id')->references('id')->on('tourney_players')
                ->onDelete('SET NULL')->onUpdate('cascade');
            $table->unsignedBigInteger('player2_id')->nullable()->index();
            $table->foreign('player2_id')->references('id')->on('tourney_players')
                ->onDelete('SET NULL')->onUpdate('cascade');
            $table->integer('player1_score');
            $table->integer('player2_score');
            $table->integer('winner_score')->nullable();
            $table->integer('winner_value')->nullable();
            $table->unsignedTinyInteger('winner_action')->nullable();
            $table->unsignedTinyInteger('looser_action')->nullable();
            $table->integer('looser_value')->nullable();
            $table->integer('match_number')->nullable();
            $table->integer('round_number')->nullable();
            $table->boolean('played');
            $table->string('round', 255)->nullable();
            $table->string('rep1', 255)->nullable();
            $table->string('rep2', 255)->nullable();
            $table->string('rep3', 255)->nullable();
            $table->string('rep4', 255)->nullable();
            $table->string('rep5', 255)->nullable();
            $table->string('rep6', 255)->nullable();
            $table->string('rep7', 255)->nullable();
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
