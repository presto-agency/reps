<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserReputationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_reputations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('sender_id');
            $table->integer('recipient_id');
            $table->integer('object_id');
            $table->integer('relation');
            $table->text('comment')         ->charset('cp1251')->nullable();
            $table->enum('rating',[1,-1])   ->default(1);
            $table->timestamps();

            $table->index('sender_id');
            $table->index('recipient_id');
            $table->index('object_id');
            $table->index('relation');
            $table->index(['object_id', 'relation']);
            $table->index('rating');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_reputations');
    }
}
