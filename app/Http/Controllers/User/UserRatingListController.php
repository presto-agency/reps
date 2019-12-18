<?php

namespace App\Http\Controllers\User;


use App\Http\Controllers\Controller;
use App\Models\UserReputation;
use App\User;
use Illuminate\Http\Request;

class UserRatingListController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $user = User::findOrFail((int)$id);

        $userReputations = UserReputation::where('recipient_id', $id)
            ->with([
                'sender',
                'sender.races',
                'sender.countries'
            ])
            ->orderBy('created_at', 'desc')
            ->paginate(30);

        return view('user.rating-list.index', compact('userReputations', 'user'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return redirect()->to('/');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return redirect()->to('/');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @param int $user_rating_list
     * @return \Illuminate\Http\Response
     */
    public function show($id, $user_rating_list)
    {
        return redirect()->to('/');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return redirect()->to('/');
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
        return redirect()->to('/');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return redirect()->to('/');
    }
}
