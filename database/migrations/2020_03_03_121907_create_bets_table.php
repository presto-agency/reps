<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bets', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('author_id');
            $table->unsignedBigInteger('winner_id')->nullable();
            $table->string('player1');
            $table->string('player2');
            $table->integer('coefficient1')->unsigned();
            $table->integer('coefficient2')->unsigned();
            $table->bigInteger('amount')->unsigned();
            $table->boolean('status')->default(true)->comment('Активные ставки = true');
            $table->timestamps();
        });

        Schema::table('bets', function (Blueprint $table) {
            $table->foreign('author_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('winner_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bets', function (Blueprint $table) {
            $table->dropForeign(['author_id']);
            $table->dropForeign(['winner_id']);
        });
        Schema::dropIfExists('bets');
    }
}
