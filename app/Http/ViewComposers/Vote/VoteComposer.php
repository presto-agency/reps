<?php


namespace App\Http\ViewComposers\Vote;


use App\User;
use Carbon\Carbon;
use App\Models\{Footer, FooterUrl, InterviewQuestion, InterviewVariantAnswer};
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

        $relation = [
            'answers',
            'userAnswers',
        ];
        $data = InterviewQuestion::with($relation)
            ->where('active', 1)
            ->withCount('userAnswers')
            ->where('for_login', self::checkAuthUser())
            ->get();
        return $data;
    }

    public static function checkAuthUser()
    {
        return auth()->check() === true ? 1 : 0;
    }

    public static function getAnswerCount()
    {
        $getIVA = null;
        $data = null;
        if (!self::getVote()->isEmpty()) {
            foreach (self::getVote() as $item) {
                $getIVA[] = InterviewVariantAnswer::with('question', 'userAnswers')
                    ->withCount('userAnswers')
                    ->where('question_id', $item->id)
                    ->get();
            }
        }
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
        return $data;
    }
}
