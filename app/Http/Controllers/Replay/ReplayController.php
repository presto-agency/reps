<?php

namespace App\Http\Controllers\Replay;

use App\Http\Controllers\Controller;
use App\Http\Requests\CommentsStoreRequests;
use App\Models\Comment;
use App\Models\Replay;
use Illuminate\Http\Request;

class ReplayController extends Controller
{


    public function index()
    {
        $type = request('type');
        $subtype = request('subtype');

        return view('replay.index', compact('type', 'subtype'));
    }

    public function create()
    {
        return abort(404);
    }

    public function store(Request $request)
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
     * @param  $id
     * @param  null  $type
     * @param  null  $subtype
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($id, $type = null, $subtype = null)
    {
        $replayShow = Replay::with([
            'users',
            'users.countries:id,name,flag',
            'users.races:id,title',
            'users'         => function ($query) {
                $query->withCount('comments');
            },
            'maps:id,name,url',
            'types:id,name,title',
            'firstCountries:id,name,flag,name',
            'secondCountries:id,name,flag,name',
            'firstRaces:id,title,code',
            'secondRaces:id,title,code',

            'comments',
            'comments.user:id,avatar,name,country_id,race_id,rating,count_negative,count_positive',
            'comments.user.countries:id,name,flag',
            'comments.user.races:id,title',
            'comments.user' => function ($query) {
                $query->withCount('comments');
            },
        ])->withCount('comments')->findOrFail($id);

        return view('replay.show', compact('replayShow'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function loadReplay()
    {
        $request = request();
        if ($request->ajax()) {
            $visible_title = false;

            if ($request->id > 0) {
                if (request()->has('subtype') && request()->filled('subtype')) {
                    $replaysAjaxLoad = self::getReplayWithTypeAjaxId($request->type, $request->subtype, $request->id);
                    $request->attributes->set('subtype', $request->subtype);
                } else {
                    $replaysAjaxLoad = self::getReplayAjaxId($request->type, $request->id);
                    $request->attributes->set('subtype', '');
                }
            } else {
                if ($request->has('subtype') && $request->filled('subtype')) {
                    $replaysAjaxLoad = self::getReplayWithTypeAjax($request->type, $request->subtype);
                    $request->attributes->set('subtype', $request->subtype);
                } else {
                    $replaysAjaxLoad = self::getReplayAjax($request->type);
                    $request->attributes->set('subtype', '');
                }
                $request->attributes->set('type', $request->type);
                $visible_title = true;
            }

            return view('replay.components.index', compact('replaysAjaxLoad', 'visible_title'));
        }
    }


    private static function getReplayWithTypeAjaxId($type, string $subtype, int $id)
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
            ->where('id', '<', $id)
            ->where('approved', true)
            ->where('user_replay', array_search($type, Replay::$type))
            ->whereHas('types', function ($query) use ($subtype) {
                $query->where('name', $subtype);
            })
            ->limit(5)
            ->get();
    }

    /**
     * @param  string  $type
     * @param  string  $subtype
     *
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    private static function getReplayWithTypeAjax($type, string $subtype)
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
            ->where('approved', true)
            ->where('user_replay', array_search($type, Replay::$type))
            ->whereHas('types', function ($query) use ($subtype) {
                $query->where('name', $subtype);
            })
            ->limit(5)
            ->get();
    }

    private static function getReplayAjaxId($type, int $id)
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
            ->where('approved', true)
            ->where('user_replay', array_search($type, Replay::$type))
            ->where('id', '<', $id)
            ->limit(5)
            ->get();
    }


    /**
     * @param  $type
     *
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    private static function getReplayAjax($type)
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
            ->where('approved', true)
            ->where('user_replay', array_search($type, Replay::$type))
            ->limit(5)
            ->get();
    }

    /**
     * Response for File
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public static function download(int $id)
    {
        $replay = Replay::findOrFail($id);
        $filePath = null;

        if (empty($replay->file)) {
            return back();
        }

        if (strpos($replay->file, '/storage') !== false) {
            $filePath = \Str::replaceFirst('/storage', 'public', $replay->file);
        }

        if (strpos($replay->file, 'storage') !== false) {
            $filePath = \Str::replaceFirst('storage', 'public', $replay->file);
        }

        $checkPath = \Storage::path($filePath);

        if (\File::exists($checkPath)) {
            return response()->download($checkPath)->setStatusCode(200);
        }

        return back();
    }

    /**
     *
     * Increment  downloaded
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public static function downloadCount(int $id)
    {
        $request = request();
        if ($request->ajax()) {
            $replay = Replay::findOrFail($id);
            $filePath = null;
            if (empty($replay->file)) {
                return \Response::json([], 404);
            }

            if (strpos($replay->file, '/storage') !== false) {
                $filePath = \Str::replaceFirst('/storage', 'public', $replay->file);
            }
            if (strpos($replay->file, 'storage') !== false) {
                $filePath = \Str::replaceFirst('storage', 'public', $replay->file);
            }

            $checkPath = \Storage::path($filePath);

            if (\File::exists($checkPath)) {
                $replay->increment('downloaded', 1);
                $replay->save();

                return response()->json(['downloaded' => $replay->downloaded], 200);
            }
        }

        return \Response::json([], 404);
    }


    /**
     * @param  \App\Http\Requests\CommentsStoreRequests  $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function saveComments(CommentsStoreRequests $request)
    {
        $content = clean($request->input('content'));

        if (empty($content)) {
            return redirect()->back();
        }
        $model = Replay::findOrFail($request->get('id'));
        $comment = new Comment([
            'user_id' => auth()->id(),
            'content' => $content,
        ]);

        $model->comments()->save($comment);

        return redirect()->back();
    }

}
