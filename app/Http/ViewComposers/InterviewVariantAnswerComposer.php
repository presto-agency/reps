<?php


namespace App\Http\ViewComposers;

use App\Models\InterviewVariantAnswer;
use Illuminate\View\View;

class InterviewVariantAnswerComposer
{

    private $category;
    /**
     * From Section->InterviewQuestion
     * @var $id ;
     * @var $method ;
     */
    public static $id;
    public static $method;
    public static $count;

    public function __construct()
    {
        $this->category = collect();

        $data = InterviewVariantAnswer::where('question_id', self::$id)->get(['id', 'question_id', 'answer',]);
        self::$count = $data->count();

        $this->category = $data;

    }

    public function compose(View $view)
    {
        $view->with([
            'answers' => $this->category,
            'method' => self::$method,
            'questionsLeft' => self::$count > 1 ? true : false,
        ]);
    }
}
