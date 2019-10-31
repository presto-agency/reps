<?php


namespace App\Http\ViewComposers\Vote;


use App\Http\Controllers\Interview\InterviewController;
use App\Models\{InterviewQuestion};
use Illuminate\View\View;


class VoteComposer
{

    public function compose(View $view)
    {
        $view->with('votes', self::getInterviewQuestion());
    }

    public static function getInterviewQuestion()
    {
        return InterviewQuestion::with(['users' => function ($query) {
            $query->where('users.id', auth()->id());
        }, 'answers' => function ($query) {
            $query->withCount('users');
        }])->withCount('userAnswers')
            ->where('for_login', InterviewController::checkAuthUser())
            ->get();
    }
}
