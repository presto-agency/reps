<?php


namespace App\Http\ViewComposers\admin;

use App\Models\InterviewQuestion;
use Illuminate\View\View;

class InterviewVariantAnswerComposer
{

    /**
     * From Section->InterviewQuestion
     * @var $id ;
     * @var $method ;
     */
    public static $id;
    public static $method;
    public static $callback;
    public static $count;

    public function compose(View $view)
    {
        $view->with('method', self::$method);
        $view->with('id', self::$id);
//        $view->with([
////            'vote' => self::getInterviewQuestion(),
//            'edit' => self::$method,
////            'questionsLeft' => self::$count > 1 ? true : false,
//        ]);
    }

//    public static function getInterviewQuestion()
//    {
//        return InterviewQuestion::with(['users' => function ($query) {
//            $query->where('users.id', auth()->id());
//        }, 'answers' => function ($query) {
//            $query->withCount('users');
//        }])->withCount('userAnswers')
//            ->firstOrFail(self::$id);
//    }
}
