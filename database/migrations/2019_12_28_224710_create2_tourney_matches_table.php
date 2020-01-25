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
            $table->unsignedBigInteger('tourney_id')->index();
            $table->foreign('tourney_id')->references('id')->on('tourney_lists')
                ->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('player1_id')->nullable()->index();
            $table->foreign('player1_id')->references('id')->on('tourney_players')
                ->onDelete('SET NULL')->onUpdate('cascade');
            $table->unsignedBigInteger('player2_id')->nullable()->index();
            $table->foreign('player2_id')->references('id')->on('tourney_players')
                ->onDelete('SET NULL')->onUpdate('cascade');
            $table->unsignedTinyInteger('player1_score')->default(0);
            $table->unsignedTinyInteger('player2_score')->default(0);
            $table->unsignedTinyInteger('winner_score')->default(0);
            $table->unsignedTinyInteger('winner_value')->default(0);
            $table->unsignedTinyInteger('winner_action')->default(0);
            $table->unsignedTinyInteger('looser_action')->default(0);
            $table->unsignedTinyInteger('looser_value')->default(0);
            $table->unsignedTinyInteger('match_number');
            $table->unsignedTinyInteger('round_number');
            $table->boolean('played');
            $table->string('round', 50);
            $table->unsignedTinyInteger('match_type')->nullable();
            $table->string('rep1')->nullable();
            $table->string('rep2')->nullable();
            $table->string('rep3')->nullable();
            $table->string('rep4')->nullable();
            $table->string('rep5')->nullable();
            $table->string('rep6')->nullable();
            $table->string('rep7')->nullable();
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