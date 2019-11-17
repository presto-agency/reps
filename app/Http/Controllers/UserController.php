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
        return redirect()->to('/');
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
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::getUserDataById($id);
        $friends = UserFriend::getFriends($user);
        $friendly = UserFriend::getFriendlies($user);
        return view('user.profile-show')->with([
            'friends'  => $friends,
            'friendly' => $friendly,
            'user'     => $user
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::findOrFail(Auth::id());
        $countries = self::getCacheData('userEditCountries', self::getCountries());
        $races = self::getCacheData('userEditRaces', self::getRaces());

        return view('user.profile-edit', compact('user', 'countries', 'races'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProfileRequest $request, $id)
    {
        UserService::updateData($request, Auth::id());

        return redirect()->route('edit_profile', ['id' => Auth::id()]);
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

    public static function getCacheData($cache_name, $data)
    {
        if (\Cache::has($cache_name) && !\Cache::get($cache_name)->isEmpty()) {
            $data_cache = \Cache::get($cache_name);
        } else {
            $data_cache = \Cache::remember($cache_name, 300, function () use ($data) {
                return $data;
            });
        }
        return $data_cache;
    }

    private static function getRaces()
    {
        return Race::all([
            'id',
            'title'
        ]);
    }

    private static function getCountries()
    {
        return Country::all([
            'id',
            'name',
            'flag'
        ]);
    }
}
