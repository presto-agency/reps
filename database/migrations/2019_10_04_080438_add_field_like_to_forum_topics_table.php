<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldLikeToForumTopicsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('forum_topics', function (Blueprint $table) {
            $table->integer('approved')         ->default(0);
            $table->string('icon')              ->nullable();
            $table->integer('negative_count')   ->default(0);
            $table->integer('positive_count')   ->default(0);
            $table->dateTime('commented_at')    ->default(\Carbon\Carbon::now());
            $table->string('updated_by_user')   ->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('forum_topics', function (Blueprint $table) {
            $table->dropColumn('approved');
            $table->dropColumn('icon');
            $table->dropColumn('negative_count');
            $table->dropColumn('positive_count');
            $table->dropColumn('commented_at');
            $table->dropColumn('updated_by_user');
        });
    }
}
