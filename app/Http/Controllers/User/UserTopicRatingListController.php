<?php

namespace App\Http\Controllers\User;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserTopicRatingListController extends Controller
{

    /**
     * @param $id
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index($id)
    {
        $userReputations = null;
        $user = User::find((int)$id);
        return view('user.rating-list.index-topic', compact('userReputations', 'user'));
    }

    public function create()
    {
        return abort(404);
    }

    public function store(Request $request)
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
}
