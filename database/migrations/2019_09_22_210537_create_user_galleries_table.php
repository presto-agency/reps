<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserGalleriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_galleries', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('picture');
            $table->unsignedBigInteger('user_id')->default(1);
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->string('sign')->nullable();
            $table->boolean('for_adults')->default(false);
            $table->integer('negative_count')->default(0);
            $table->integer('positive_count')->default(0);

            $table->longText('comment')->nullable();

            $table->integer('rating')->default(0);
            $table->integer('comments_count')->default(0);
            $table->integer('reviews')->default(0);
            $table->softDeletes();
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
        Schema::dropIfExists('user_galleries');
    }
}
