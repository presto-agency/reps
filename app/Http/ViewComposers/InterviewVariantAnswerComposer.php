<?php


namespace App\Http\ViewComposers;

use Illuminate\View\View;

class InterviewVariantAnswerComposer
{

    private $category;

    public function __construct()
    {
        $this->category = collect();

        $columns = [
            'id',
            'question_id',
            'answer',
        ];
        $data = \DB::table('interview_variant_answers')->select($columns)->get();

        $this->category = $data;

    }

    public function compose(View $view)
    {

        $view->with('answers', $this->category);
    }
}
