<?php


namespace App\Http\ViewComposers\LeftOrRightSide;


use App\Models\{InterviewQuestion};
use Illuminate\View\View;


class InterviewComposer
{

    private $votes;

    public function __construct()
    {
        $this->votes = collect();

        $votes = $this->getInterviewQuestion();

        $this->votes = $votes;
    }

    public function compose(View $view)
    {
        $view->with('votes', $this->votes);
    }

    public function getInterviewQuestion()
    {
        return InterviewQuestion::with([
            'users'      => function ($query) {
                $query->where('users.id', auth()->id());
            }, 'answers' => function ($query) {
                $query->withCount('users');
            },
        ])->withCount('userAnswers')->get();
    }

}
