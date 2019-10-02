<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChatPictureTagTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chat_picture_tag', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('chat_picture_id');
            $table->foreign('chat_picture_id')
                ->references('id')->on('chat_pictures')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->unsignedBigInteger('tag_id');
            $table->foreign('tag_id')
                ->references('id')->on('tags')
                ->onUpdate('cascade')
                ->onDelete('cascade');

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
        Schema::dropIfExists('chat_picture_tag');
    }
}
