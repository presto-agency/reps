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
     * @return \Illuminate\Http\RedirectResponse
     */
    public function index()
    {
        return redirect()->to('/');
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function create()
    {
        return redirect()->to('/');
    }

    /**
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        return redirect()->to('/');
    }

    /**
     * @param $id
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
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
     * @param $id
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $user = User::findOrFail(Auth::id());
        $countries = self::getCacheData('userEditCountries', self::getCountries());
        $races = self::getCacheData('userEditRaces', self::getRaces());

        return view('user.profile-edit', compact('user', 'countries', 'races'));
    }


    /**
     * @param  \App\Http\Requests\UpdateProfileRequest  $request
     * @param $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateProfileRequest $request, $id)
    {

        UserService::updateData($request, Auth::id());

        return redirect()->route('edit_profile', ['id' => Auth::id()]);
    }

    /**
     * @param $id
     *
     * @return \Illuminate\Http\RedirectResponse
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

    /**
     * @return \App\Models\Race[]|\Illuminate\Database\Eloquent\Collection
     */
    private static function getRaces()
    {
        return Race::all([
            'id',
            'title'
        ]);
    }

    /**
     * @return \App\Models\Country[]|\Illuminate\Database\Eloquent\Collection
     */
    private static function getCountries()
    {
        return Country::all([
            'id',
            'name',
            'flag'
        ]);
    }
}
