<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\ReplayStoreRequest;
use App\Http\Requests\ReplayUpdateRequest;
use App\Models\{Replay};
use App\Services\SrcFromUrl\Generator;
use Illuminate\Http\Request;

class UserReplayController extends Controller
{


    public function index($id, $type = '')
    {
        return view('user.replay.index');
    }

    public function show($id, $user_replay, $type = '')
    {
        return abort(404);
    }

    public function destroy($id, $user_replay)
    {
        return abort(404);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('user.replay.create');
    }

    /**
     * @param  int  $id
     * @param  int  $user_replay
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|void
     */
    public function edit($id, $user_replay)
    {
        /**
         * Abort if auth user role = 'user'
         */
        if ((auth()->check() && auth()->user()->roles->name == 'user')) {
            return abort(404);
        }

        $userReplayEdit = Replay::findOrfail($user_replay);

        return view('user.replay.edit', compact('userReplayEdit'));
    }

    /**
     * @param  \App\Http\Requests\ReplayStoreRequest  $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(ReplayStoreRequest $request)
    {
        /**
         * Clean all HTML STYLE and SCRIPT
         */
        $title      = clean($request->get('title'));
        $content    = clean($request->get('short_description'));
        $src_iframe = clean($request->get('src_iframe'));

        if (empty($title)) {
            return redirect()->back();
        }
        /**
         * If no file and iframe empty after clean
         */
        if (empty($src_iframe) && ! $request->hasFile('file')) {
            return redirect()->back();
        }

        $data = new Replay;
        $this->modelColumns($data, $title, $content, $src_iframe, $request);
        $data->save();


        return redirect()->route('replay.show', ['replay' => $data->id, 'type='.Replay::$type[$data->user_replay]]);
    }

    /**
     * @param  \App\Http\Requests\ReplayUpdateRequest  $request
     * @param $id
     * @param $user_replay
     *
     * @return \Illuminate\Http\RedirectResponse|void
     */
    public function update(ReplayUpdateRequest $request, $id, $user_replay)
    {
        /**
         * Abort if auth user role = 'user'
         */
        if ((auth()->check() && auth()->user()->roles->name == 'user')) {
            return abort(404);
        }
        /**
         * Clean all HTML STYLE and SCRIPT
         */
        $title      = clean($request->get('title'));
        $content    = clean($request->get('short_description'));
        $src_iframe = clean($request->get('src_iframe'));

        if (empty($title)) {
            return back();
        }

        $data = Replay::find($user_replay);
        $this->modelColumns($data, $title, $content, $src_iframe, $request);
        $data->save();


        return redirect()->route('replay.show', ['replay' => $data->id, 'type='.Replay::$type[$data->user_replay]]);
    }

    public function modelColumns($data, $title, $content, $src_iframe, $request)
    {
        $data->title             = $title;
        $data->first_race        = $request->get('first_race');
        $data->second_race       = $request->get('second_race');
        $data->first_location    = $request->get('first_location');
        $data->second_location   = $request->get('second_location');
        $data->first_country_id  = $request->get('first_country');
        $data->second_country_id = $request->get('second_country');
        $data->map_id            = $request->get('map');
        $data->type_id           = $request->get('subtype');
        $data->user_replay       = $request->get('type');
        $data->content           = $content;
        if ($request->has('src_iframe')) {
            $data->src_iframe = htmlspecialchars_decode($src_iframe);
        }

        if ($request->hasFile('file')) {
            /**
             * Upload file on server
             */
            $path       = \Storage::disk('public')->putFileAs('files/replays', $request->file('file'), \Str::random(32).$request->file('file')->getClientOriginalName(), 'public');
            $data->file = 'storage/'.$path;
        }
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function loadUserReplay()
    {
        $request = request();
        if ($request->ajax()) {
            $visible_title = false;
            if ($request->id > 0) {
                $userReplaysAjaxLoad = self::getUserReplaysAjaxId($request->user_id, $request->id, $request->type);
            } else {
                $userReplaysAjaxLoad = self::getUserReplaysAjax($request->user_id, $request->type);
                $visible_title       = true;
            }
            $request->attributes->set('type', $request->type);

            return view('user.replay.components.index', compact('userReplaysAjaxLoad', 'visible_title'));
        }
    }

    /**
     * @param  int  $user_id
     * @param  int  $id
     * @param  string  $type
     *
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public static function getUserReplaysAjaxId(int $user_id, int $id, string $type)
    {
        return Replay::with([
            'users:id,name,avatar',
            'maps:id,name',
            'firstCountries:id,flag,name',
            'secondCountries:id,flag,name',
            'firstRaces:id,title,code',
            'secondRaces:id,title,code',
        ])->orderByDesc('id')
            ->withCount('comments')
            ->where('user_id', $user_id)
            ->where('id', '<', $id)
            ->where('user_replay', array_search($type, Replay::$type))
            ->limit(5)
            ->get();
    }

    /**
     * @param  int  $user_id
     * @param  string  $type
     *
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public static function getUserReplaysAjax(int $user_id, string $type)
    {
        return Replay::with([
            'users:id,name,avatar',
            'maps:id,name',
            'firstCountries:id,flag,name',
            'secondCountries:id,flag,name',
            'firstRaces:id,title,code',
            'secondRaces:id,title,code',
        ])->orderByDesc('id')
            ->withCount('comments')
            ->where('user_id', $user_id)
            ->where('user_replay', array_search($type, Replay::$type))
            ->limit(5)
            ->get();
    }

    /**
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function iframe(Request $request)
    {
        if ($request->ajax()) {
            try {
                $src = new Generator($request->get('video_iframe_url'));

                if (empty($src->getSrcIframe())) {
                    return $this->redirectToWrongUrl();
                }

                return \Response::json([
                    'success' => true,
                    'message' => $src->getSrcIframe(),
                ], 200);
            } catch (\Exception $e) {
                return $this->redirectToWrongUrl();
            }
        }

        return \Response::json([
            'success' => false,
            'message' => 'Указаный url не поддерживаеться',
        ], 404);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    private function redirectToWrongUrl()
    {
        return \Response::json([
            'success' => false,
            'message' => 'Указаный url не поддерживаеться',
        ], 400);
    }

}
