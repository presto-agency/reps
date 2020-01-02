<?php

namespace App\Http\Controllers\User;


use App\Http\Controllers\Controller;
use App\Models\UserReputation;
use App\User;
use Illuminate\Http\Request;

class UserRatingListController extends Controller
{

    /**
     * @param int $id
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(int $id)
    {
        $user = User::findOrFail($id);

        $userReputations = UserReputation::where('recipient_id', $user->id)
            ->with([
                'sender',
                'sender.races',
                'sender.countries'
            ])
            ->orderBy('created_at', 'desc')
            ->paginate(30);

        return view('user.rating-list.index', compact('userReputations', 'user'));
    }


    public function create()
    {
        return abort(404);
    }


    public function store(Request $request)
    {
        return abort(404);
    }

    public function show($id, $user_rating_list)
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
