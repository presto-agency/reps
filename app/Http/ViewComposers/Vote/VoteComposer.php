<?php


namespace App\Http\ViewComposers\Vote;


use App\Http\Controllers\Interview\InterviewController;
use App\Models\{InterviewQuestion, InterviewVariantAnswer};
use Illuminate\View\View;

class VoteComposer
{
    private static $ttl = 300;

    public function compose(View $view)
    {
        $view->with('votes', self::getVote());
        $view->with('answersCount', self::getAnswerCount());
    }

//    public static function getCacheVote($cache_name)
//    {
//        if (\Cache::has($cache_name) && !empty(\Cache::get($cache_name))) {
//            $data_cache = \Cache::get($cache_name);
//        } else {
//            $data_cache = \Cache::remember($cache_name, self::$ttl, function () {
//                return self::getVote();
//            });
//        }
//        return $data_cache;
//    }


    private static function getVote()
    {
        $data = null;
        if (InterviewController::checkAuthUser() == 1) {
            $relation = ['answers', 'userAnswers', 'userAlreadyAnswer:id,question_id,user_id'];
        } else {
            $relation = ['answers', 'userAnswers',];
        }
        $data = InterviewQuestion::with($relation)
            ->where('active', 1)
            ->withCount('userAnswers')
            ->where('for_login', InterviewController::checkAuthUser())
            ->get();

        return $data;
    }

    private static function getAnswerCount()
    {
        $getIVA = null;
        $data = null;
        if (!self::getVote()->isEmpty()) {
            foreach (self::getVote() as $item) {
                $getIVA[] = self::getIVA($item->id);
            }
        }
        if (!empty($getIVA)) {
            foreach ($getIVA as $items) {
                if (!empty($items)) {
                    foreach ($items as $ite) {
                        $data[] = [
                            'answer' => $ite->answer,
                            'answer_count' => $ite->user_answers_count,
                            'question_id' => $ite->question_id,
                        ];
                    }
                }
            }
        }
        return $data;
    }

    private static function getIVA($question_id)
    {
        $data = null;

        $data = InterviewVariantAnswer::with(['question'])
            ->withCount('userAnswers')
            ->where('question_id', $question_id)
            ->get();

        return $data;
    }
}
