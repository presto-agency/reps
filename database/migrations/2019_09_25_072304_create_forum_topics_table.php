<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateForumTopicsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('forum_topics', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');

            $table->unsignedBigInteger('forum_section_id');
            $table->foreign('forum_section_id')
                ->references('id')->on('forum_sections')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->integer('reviews')->default(0);
            $table->string('rating');
            $table->text('preview_content');
            $table->string('preview_img')->nullable();
            $table->longText('content');
            $table->integer('comments_count')->default(0);
            $table->boolean('news')->default(0);
            $table->dateTime('start_on')->nullable();
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
        Schema::dropIfExists('forum_topics');
    }

}
