<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTourneyListsMapPoolsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tourney_lists_map_pools', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('tourney_id')->index();
            $table->foreign('tourney_id')->references('id')->on('tourney_lists')
                ->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('map_id')->index()->nullable();
            $table->foreign('map_id')->references('id')->on('replay_maps')
                ->onDelete('SET NULL')->onUpdate('cascade');
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
        Schema::dropIfExists('tourney_lists_map_pools');
    }

}
