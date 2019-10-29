<?php

namespace App\Http\Controllers\Interview;

use App\Http\Requests\InterviewStore;
use App\Models\InterviewUserAnswers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class InterviewController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param InterviewStore $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(InterviewStore $request)
    {
        if (empty(self::checkUserAnswer($request->question_id))) {
            self::storeIUA($request);
        }
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * @param $request
     */
    private static function storeIUA($request)
    {
        $storeData = new InterviewUserAnswers;
        $storeData->question_id = $request->question_id;
        $storeData->answer_id = $request->answer_id;
        $storeData->user_id = self::getAuthUser()->id;
        $storeData->save();

    }

    /**
     * @param $question_id
     * @return mixed
     */
    public static function checkUserAnswer($question_id)
    {
        return InterviewUserAnswers::where('question_id', $question_id)->where('user_id', self::getAuthUser()->id)->value('id');
    }

    public static function checkAuthUser()
    {
        return auth()->check() === true ? 1 : 0;
    }
    public static function getAuthUser()
    {
        return auth()->user();
    }
}
