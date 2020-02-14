<?php

use App\Traits\MigrationsTrait\MigrationForeign;
use App\Traits\MigrationsTrait\MigrationIndex;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;


class Mod5ForumTopicsTable extends Migration
{

    use MigrationIndex, MigrationForeign;

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('forum_topics', function (Blueprint $table) {
            $table->dropColumn('comments_count');
            $table->dropColumn('preview');
            $table->dropColumn('icon');
            $table->dropColumn('approved');
            $table->dropColumn('updated_by_user');
        });
        Schema::disableForeignKeyConstraints();
        $this->_createForeignIfExist(
            'forum_topics',
            'forum_topics_user_id_foreign',
            'user_id',
            'id', 'users',
            'cascade',
            'cascade');
        $this->_createForeignIfExist(
            'forum_topics',
            'forum_topics_forum_section_id_foreign',
            'forum_section_id',
            'id',
            'forum_sections',
            'cascade',
            'cascade');
        $this->_createIndexIfNotExist('forum_topics', 'title', 'forum_topics_title_index');
        $this->_createIndexIfNotExist('forum_topics', 'forum_section_id', 'forum_topics_forum_section_id_index');
        $this->_createIndexIfNotExist('forum_topics', 'user_id', 'forum_topics_user_id_index');
        $this->_createIndexIfNotExist('forum_topics', 'news', 'forum_topics_news_index');
        $this->_createIndexIfNotExist('forum_topics', 'fixing', 'forum_topics_fixing_index');
        $this->_createIndexIfNotExist('forum_topics', 'commented_at', 'forum_topics_commented_at_index');

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
            $table->unsignedBigInteger('comments_count')->default(0);
            $table->boolean('preview')->default(false);
            $table->string('icon')->nullable();
            $table->boolean('approved')->default(false);
            $table->dateTime('updated_by_user')->nullable();
        });
        Schema::disableForeignKeyConstraints();
        $this->_dropForeignIfExist('forum_topics', 'forum_topics_user_id_foreign');
        $this->_dropForeignIfExist('forum_topics', 'forum_topics_forum_section_id_foreign');
        $this->_dropIndexIfExist('forum_topics', 'forum_topics_user_id_forum_section_id_index');
        $this->_dropIndexIfExist('forum_topics', 'forum_topics_forum_section_id_index');
        $this->_dropIndexIfExist('forum_topics', 'forum_topics_title_index');
        $this->_dropIndexIfExist('forum_topics', 'forum_topics_user_id_index');
        $this->_dropIndexIfExist('forum_topics', 'forum_topics_news_index');
        $this->_dropIndexIfExist('forum_topics', 'forum_topics_fixing_index');
        $this->_dropIndexIfExist('forum_topics', 'forum_topics_commented_at_index');
        Schema::enableForeignKeyConstraints();
    }

}
