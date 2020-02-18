<?php

use App\Traits\MigrationsTrait\MigrationIndex;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Mod6ForumTopicsTable extends Migration
{

    use MigrationIndex;

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('forum_topics', function (Blueprint $table) {
            $table->boolean('hide')->default(false)->after('fixing');
        });
        Schema::disableForeignKeyConstraints();
        $this->_createIndexIfNotExist('forum_topics', 'hide', 'forum_topics_hide_index');
        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('forum_topics', function (Blueprint $table) {
            $table->dropColumn('hide');
        });
        Schema::disableForeignKeyConstraints();
        $this->_dropIndexIfExist('forum_topics', 'forum_topics_hide_index');
        Schema::enableForeignKeyConstraints();
    }

}
