<?php

namespace App\Http\Controllers\Comment;

use App\Models\Comment;
use App\Models\Replay;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CommentController extends Controller
{
    public $model;
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
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function store(Request $request)
    {
        dd($request->model);
        if (!in_array($request->model, ['Replay']))
        {
            throw new \Exception('Invalid model');
        }
        $modelName = '\\App\\Models\\'.$request->model;
        $this->model = new $modelName;
        dd($this->model);
        $model =   $this->model::find($request->id);
        $comment = new Comment([
            'user_id' => self::getAuthUser()->id,
            'content' => $request->input('content')
        ]);
        $model->comments()->save($comment);
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

    private static function getAuthUser()
    {
        return auth()->user();
    }
}
