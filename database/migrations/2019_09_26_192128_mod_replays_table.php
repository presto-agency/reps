<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModReplaysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::table('replays', function (Blueprint $table) {

            $table->string('file');
            $table->timestamp('start_date')->nullable();
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public
    function down()
    {
        Schema::table('replays', function (Blueprint $table) {

            $table->dropColumn('start_date');
            $table->dropColumn('file');
        });
    }
}
