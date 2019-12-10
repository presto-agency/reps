<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class PreparingForumTopicsForTransfer extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /**
         * Disable forKeys
         */
        Schema::table('forum_topics', function (Blueprint $table) {
            Schema::disableForeignKeyConstraints();
        });
        /**
         * Drop forKeys
         */
        Schema::table('forum_topics', function (Blueprint $table) {
            $foreignKeys = $this->listTableForeignKeys('forum_topics');
            in_array('forum_topics_forum_section_id_foreign', $foreignKeys)
            === true
                ? $table->dropForeign('forum_topics_forum_section_id_foreign')
                : null;
            in_array('forum_topics_user_id_foreign', $foreignKeys) === true
                ? $table->dropForeign('forum_topics_user_id_foreign') : null;
        });
        /**
         * Change columns
         */
        Schema::table('forum_topics', function (Blueprint $table) {
            $table->longText('preview_content')->change();
        });

        /**
         * Add NewForKeys and columns
         */
        Schema::table('forum_topics', function (Blueprint $table) {

            $table->unsignedBigInteger('forum_section_id')->nullable()
                ->change();
            $table->unsignedBigInteger('user_id')->nullable()->change();

            $table->foreign('forum_section_id')->references('id')
                ->on('forum_sections')->onDelete('SET NULL');
            $table->foreign('user_id')->references('id')->on('users')
                ->onDelete('SET NULL');
        });
        /**
         * Enable forKeys
         */
        Schema::table('forum_topics', function (Blueprint $table) {
            Schema::enableForeignKeyConstraints();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }

    /**
     * @param $table
     *
     * @return array
     */
    public function listTableForeignKeys($table)
    {
        $conn = Schema::getConnection()->getDoctrineSchemaManager();

        return array_map(function ($key) {
            return $key->getName();
        }, $conn->listTableForeignKeys($table));
    }

}
