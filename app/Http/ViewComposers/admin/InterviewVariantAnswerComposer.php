<?php


namespace App\Http\ViewComposers\admin;

use App\Models\InterviewVariantAnswer;
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
    public static $answers;
    public static $answersLeft;

    public function __construct()
    {

//        self::$answers = $data = InterviewVariantAnswer::where('question_id', self::$id)->get();
//
//        if (self::$method == 'edit') {
//            self::$answersLeft = $data->count() > 1 ? true : false;
//        }

    }

    public function compose(View $view)
    {
//        $view->with('id', self::$id);
//        $view->with('method', self::$method);
//        $view->with('answers', self::$answers);
//        $view->with('answersLeft', self::$answersLeft);
    }
}
