<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReplaysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('replays', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->string('user_replay');
            $table->unsignedBigInteger('map_id');
            $table->foreign('map_id')->references('id')->on('replay_maps')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('first_country_id');
            $table->foreign('first_country_id')->references('id')->on('countries')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('second_country_id');
            $table->foreign('second_country_id')->references('id')->on('countries')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('first_race');
            $table->foreign('first_race')->references('id')->on('races')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('second_race');
            $table->foreign('second_race')->references('id')->on('races')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('type_id');
            $table->foreign('type_id')->references('id')->on('replay_types')->onDelete('cascade')->onUpdate('cascade');

            $table->integer('comments_count')->default(0);
            $table->double('user_rating', 10, 2)->default(0);
            $table->integer('negative_count')->default(0);
            $table->integer('rating')->default(0);
            $table->integer('positive_count')->default(0);
            $table->boolean('approved')->default(true);
            $table->integer('first_location')->nullable();
            $table->string('first_name')->nullable();
            $table->integer('first_apm')->nullable();
            $table->integer('second_location')->nullable();
            $table->string('second_name')->nullable();
            $table->integer('second_apm')->nullable();
            $table->longText('content')->nullable();
            $table->integer('downloaded')->default(0);




            $table->index('user_id');
            $table->index('map_id');
            $table->index('first_country_id');
            $table->index('second_country_id');
            $table->index('first_race');
            $table->index('second_race');
            $table->index('type_id');
            $table->index('approved');

//            $table->time('length')->default('00:00:00');
//            $table->integer('game_version_id')->default(0);
//            $table->enum('creating_rate', ['7','8','9','10','Cool','Best'])->default('10');
//            $table->string('championship')->nullable();
//            $table->integer('reps_id')->nullable();

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
        Schema::dropIfExists('replays');
    }
}
