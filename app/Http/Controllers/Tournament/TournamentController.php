<?php

namespace App\Http\Controllers\Tournament;


use App\Http\Controllers\Controller;
use App\Http\Requests\TourneyRegisterPlayerRequest;
use App\Models\TourneyList;
use App\Models\TourneyPlayer;
use Illuminate\Http\Request;

class TournamentController extends Controller
{

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('tournament.index');
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
     * @param  int  $id
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(int $id)
    {
        $tournament = $this->getTournament($id);

        if (array_key_exists($tournament->type, $tournament::$tourneyType)) {
            $tournament->load([
                'playersNew' => function ($query) {
                    $query->with([
                        'user' => function ($query) {
                            $query->select(['id', 'name', 'email', 'race_id', 'country_id']);
                        },
                        'user.races:id,title',
                        'user.countries:id,name,flag',
                    ])->orderByDesc('check')
                        ->orderByDesc('victory_points')
                        ->orderBy('defeat')
                        ->select(['id', 'tourney_id', 'user_id', 'victory_points', 'description', 'check']);
                },
            ]);
        } else {
            $tournament->load([
                'players' => function ($query) {
                    $query->with([
                        'user' => function ($query) {
                            $query->select(['id', 'name', 'email', 'race_id', 'country_id']);
                        },
                        'user.races:id,title',
                        'user.countries:id,name,flag',
                    ])->orderByDesc('check')
                        ->orderByRaw('LENGTH(place_result)')
                        ->orderBy('place_result')
                        ->select(['id', 'tourney_id', 'user_id', 'place_result', 'description', 'check']);
                },
            ]);
        }
        $data = $this->createDataArray($tournament);

        return view('tournament.show', compact('tournament', 'data'));
    }

    /**
     * @param $tournament
     *
     * @return array
     */
    private function createDataArray($tournament): array
    {
        $data = [];
        if (isset($tournament->matches) && $tournament->matches->isNotEmpty()) {
            if (array_key_exists($tournament->type, $tournament::$tourneyType)) {
                $i = 0;
                foreach ($tournament->matches->unique('round') as $item) {
                    $i++;
                    $data['round'][$i] = [
                        'title'       => $item->round,
                        'roundNumber' => $item->round_number,
                    ];
                }
                foreach ($data['round'] as $key => $item) {
                    $data['matches'][$key][] = collect($tournament->matches->where('round_number', $item['roundNumber'])->all());
                    if (isset($tournament->mapsPool) && $tournament->mapsPool->isNotEmpty()) {
                        $mapsCount                      = $tournament->maps_pool_count;
                        $mapIndex                       = $item['roundNumber'] % $mapsCount;
                        $data['round'][$key]['mapName'] = $tournament->mapsPool[$mapIndex]->map->name;
                        $data['round'][$key]['mapUrl']  = $tournament->mapsPool[$mapIndex]->map->url;
                    }
                }

                return $data;
            } else {
                foreach ($tournament->matches as $item) {
                    $data['round'][$item->round_number]['title'] = $item->round;
                    $data['matches'][$item->round_number][]      = $item;
                    if (isset($tournament->mapsPool) && $tournament->mapsPool->isNotEmpty()) {
                        $mapsCount                                     = $tournament->maps_pool_count;
                        $mapIndex                                      = $item->round_number % $mapsCount;
                        $data['round'][$item->round_number]['mapName'] = $tournament->mapsPool[$mapIndex]->map->name;
                        $data['round'][$item->round_number]['mapUrl']  = $tournament->mapsPool[$mapIndex]->map->url;
                    }
                }
            }
        }

        return $data;
    }

    /**
     * @param  int  $id
     *
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model
     */
    private function getTournament(int $id)
    {
        return TourneyList::with([
            'mapsPool:id,tourney_id,map_id',
            'mapsPool.map:id,name,url',
            'player'  => function ($query) {
                $query->select(['id', 'tourney_id', 'user_id'])->where('user_id', auth()->id());
            },
            'matches' => function ($query) {
                $query->with([
                    'player1.user:id,name,avatar',
                    'player2.user:id,name,avatar',
                ])->orderBy('round_number');
            },
        ])->withCount(['players', 'banPlayers', 'mapsPool',])
            ->where('visible', true)->findOrFail($id);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function loadTournament()
    {
        $request = request();
        if ($request->ajax()) {
            if ($request->headers->has('referer')) {
                $routName = app('router')->getRoutes()->match(app('request')->create($request->headers->get('referer')))->getName();
                if ($routName == 'tournament.index') {
                    $visible_title = false;
                    if ($request->id > 0) {
                        $tournamentList = self::getTourneyListAjaxId($request->id);
                    } else {
                        $tournamentList = self::getTourneyListAjax();
                        $visible_title  = true;
                    }
                    $tournamentStatus = TourneyList::$status;

                    return view('tournament.components.index',
                        compact('tournamentList', 'tournamentStatus', 'visible_title'));
                }
            }
        }

        return null;
    }

    /**
     * @param  int  $id
     *
     * @return mixed
     */
    public static function getTourneyListAjaxId(int $id)
    {
        return TourneyList::select(['id', 'name', 'place', 'start_time', 'status'])
            ->withCount(['checkPlayers', 'players',])
            ->where('visible', 1)
            ->where('id', '<', $id)
            ->orderByDesc('id')
            ->limit(5)
            ->get();
    }

    /**
     * @return mixed
     */
    public static function getTourneyListAjax()
    {
        return TourneyList::select(['id', 'name', 'place', 'start_time', 'status'])
            ->withCount(['checkPlayers', 'players',])
            ->where('visible', 1)
            ->orderByDesc('id')
            ->limit(5)
            ->get();
    }

    /**
     * @param  \App\Http\Requests\TourneyRegisterPlayerRequest  $request
     *
     * @return |null
     */
    public function registerPlayer(TourneyRegisterPlayerRequest $request)
    {
        $description = clean($request->get('description'));
        if ($request->ajax() && $request->headers->has('referer') && ! empty($description)) {
            $routName = app('router')->getRoutes()->match(app('request')->create($request->headers->get('referer')))->getName();
            if ($routName == 'tournament.show') {
                $tourney = TourneyList::with([
                    'player' => function ($query) {
                        $query->where('user_id', auth()->id());
                    },
                ])->where('status', array_search('REGISTRATION', TourneyList::$status))->find($request->get('tourneyId'));

                if ( ! empty($tourney) && empty($tourney->player)) {
                    $player              = new TourneyPlayer;
                    $player->user_id     = auth()->id();
                    $player->description = $description;

                    $tourney->player()->save($player);

                    return \Response::json([
                        'success' => true,
                        'message' => 'Вы успешно присоединились к турниру.',
                    ], 200);
                }
            }
        }

        return \Response::json([
            'success' => false,
            'message' => 'Ошибка при добавлении к турниру.',
        ], 400);
    }

}
