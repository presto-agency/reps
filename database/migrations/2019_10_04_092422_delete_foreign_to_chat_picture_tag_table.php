<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DeleteForeignToChatPictureTagTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('chat_picture_tag', function (Blueprint $table) {
            $table->dropForeign(['chat_picture_id']);
            $table->dropForeign(['tag_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('chat_picture_tag', function (Blueprint $table) {
            //
        });
    }
}
