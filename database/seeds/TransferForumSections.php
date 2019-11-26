<?php

use App\Models\ForumSection;
use Carbon\Carbon;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Seeder;

class TransferForumSections extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /**
         * Disable forKeys
         */
        Schema::table(
            'forum_sections', function (Blueprint $table) {
            Schema::disableForeignKeyConstraints();
        }
        );
        /**
         * Clear table
         */
        ForumSection::query()->whereNotNull('id')->delete();
        /**
         * Remove autoIncr
         */
//        Schema::table(
//            'forum_sections', function (Blueprint $table) {
//            $table->unsignedBigInteger('id', false)->change();
//        }
//        );
        /**
         * Get and Insert data
         */
        DB::connection("mysql2")->table("forum_sections")
            ->chunkById(
                100, function ($repsForumSections) {
                try {
                    $insertItems = [];
                    foreach ($repsForumSections as $item) {
                        $insertItems[] = [
                            'id'                  => $item->id,
                            'position'            => $item->position,
                            'name'                => $item->name,
                            'title'               => $item->title,
                            'description'         => $item->description,
                            'is_active'           => $item->is_active,
                            'is_general'          => $item->is_general,
                            'user_can_add_topics' => $item->user_can_add_topics,
                            'created_at'          => Carbon::now(),
                        ];
                    }
                    DB::table("forum_sections")->insertOrIgnore($insertItems);
                } catch (\Exception $e) {
                    dd($e, $item);
                }
            }
            );
        /**
         * Add autoIncr
         */
//        Schema::table(
//            'forum_sections', function (Blueprint $table) {
//            $table->unsignedBigInteger('id', true)->change();
//        }
//        );
        /**
         * Enable forKeys
         */
        Schema::table(
            'forum_sections', function (Blueprint $table) {
            Schema::enableForeignKeyConstraints();
        }
        );
    }

}
