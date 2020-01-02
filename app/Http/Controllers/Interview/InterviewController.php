<?php

namespace App\Http\Controllers\Interview;

use App\Http\Controllers\Controller;
use App\Http\Requests\InterviewStoreRequests;
use App\Models\InterviewUserAnswers;
use Illuminate\Http\Request;

class InterviewController extends Controller
{

    public function index()
    {
        return abort(404);
    }

    public function create()
    {
        return abort(404);
    }


    public function show($id)
    {
        return abort(404);
    }

    public function edit($id)
    {
        return abort(404);
    }


    public function update(Request $request, $id)
    {
        return abort(404);
    }


    public function destroy($id)
    {
        return abort(404);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  InterviewStoreRequests  $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(InterviewStoreRequests $request)
    {
        if (empty(self::checkUserAnswer($request->question_id))) {
            self::storeIUA($request);
        }

        return back();
    }

    /**
     * @param $request
     */
    private static function storeIUA($request)
    {
        $storeData              = new InterviewUserAnswers;
        $storeData->question_id = $request->question_id;
        $storeData->answer_id   = $request->answer_id;
        $storeData->user_id     = auth()->id();
        $storeData->save();
    }

    /**
     * @param $question_id
     *
     * @return mixed
     */
    public static function checkUserAnswer($question_id)
    {
        return InterviewUserAnswers::where('question_id', $question_id)->where('user_id', auth()->id())->value('id');
    }

}
