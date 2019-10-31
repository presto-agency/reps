<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateProfileRequest;
use App\Models\Country;
use App\Models\Race;
use App\Models\UserFriend;
use App\Services\User\UserService;
use App\User;
use Auth;
use Illuminate\Http\Request;

class UserController extends Controller
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        /*if (Auth::user()) {
            return abort(403);
        }*/
        $user = User::getUserDataById($id);
        if (!$user) {
            abort(404);
        }

//        $friends = UserFriend::getFriends($user);
//        $friendly = UserFriend::getFriendlies($user);

        return view('user.index')->with([
//            'friends' => $friends,
//            'friendly' => $friendly,
            'user' => $user
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('user.edit_profile')->with(['user' => Auth::user(), 'countries' => Country::all(), 'races' => Race::all()]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProfileRequest $request, $id)
    {
        UserService::updateData($request, Auth::id());
        return redirect()->route('user_profile', ['id' => Auth::id()]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
