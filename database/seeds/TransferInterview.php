<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Seeder;

class TransferInterview extends Seeder
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
        Schema::table('interview_questions', function (Blueprint $table) {
            Schema::disableForeignKeyConstraints();
        });
        Schema::table('interview_user_answers', function (Blueprint $table) {
            Schema::disableForeignKeyConstraints();
        });
        Schema::table('interview_variant_answers', function (Blueprint $table) {
            Schema::disableForeignKeyConstraints();
        });
        /**
         * Clear table
         */
        DB::table('interview_questions')->delete();
        DB::table('interview_user_answers')->delete();
        DB::table('interview_variant_answers')->delete();
        /**
         * Get and Insert data
         */
        DB::connection("mysql2")->table("interview_questions")
            ->chunkById(100, function ($repsInterviewQuestions) {
                try {
                    $insertItems = [];
                    foreach ($repsInterviewQuestions as $item) {
                        $insertItems[] = [
                            'id'         => $item->id,
                            'question'   => $item->question,
                            'active'     => $item->is_active,
                            'for_login'  => $item->for_login,
                            'created_at' => $item->created_at,
                            'updated_at' => $item->updated_at,
                        ];
                    }
                    DB::table("interview_questions")->insertOrIgnore($insertItems);
                } catch (\Exception $e) {
                    dd($e, $item);
                }
            });
        DB::connection("mysql2")->table("interview_user_answers")
            ->chunkById(100, function ($repsInterviewUserAnswers) {
                try {
                    $insertItems = [];
                    foreach ($repsInterviewUserAnswers as $item) {
                        $insertItems[] = [
                            'id'          => $item->id,
                            'user_id'     => $item->user_id,
                            'question_id' => $item->question_id,
                            'answer_id'   => $item->answer_id,
                            'created_at'  => $item->created_at,
                            'updated_at'  => $item->updated_at,
                        ];
                    }
                    DB::table("interview_user_answers")->insertOrIgnore($insertItems);
                } catch (\Exception $e) {
                    dd($e, $item);
                }
            });
        DB::connection("mysql2")->table("interview_variants_answers")
            ->chunkById(100, function ($repsInterviewVariantAnswers) {
                try {
                    $insertItems = [];
                    foreach ($repsInterviewVariantAnswers as $item) {
                        $insertItems[] = [
                            'id'          => $item->id,
                            'answer'      => $item->answer,
                            'question_id' => $item->question_id,
                            'created_at'  => $item->created_at,
                            'updated_at'  => $item->updated_at,
                        ];
                    }
                    DB::table("interview_variant_answers")->insertOrIgnore($insertItems);
                } catch (\Exception $e) {
                    dd($e, $item);
                }
            });
        /**
         * Enable forKeys
         */
        Schema::table('interview_questions', function (Blueprint $table) {
            Schema::enableForeignKeyConstraints();
        });
        Schema::table('interview_user_answers', function (Blueprint $table) {
            Schema::enableForeignKeyConstraints();
        });
        Schema::table('interview_variant_answers', function (Blueprint $table) {
            Schema::enableForeignKeyConstraints();
        });
    }
}
