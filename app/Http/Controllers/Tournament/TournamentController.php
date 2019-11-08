<?php

namespace App\Http\Controllers\Tournament;


use App\Models\ReplayMap;
use App\Models\TourneyList;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TournamentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tournamentList = TourneyList::with('admin_user', 'win_player')
            ->withCount('players')
            ->withCount('checkin_players')
            ->paginate(15);
        $tournamentStatus = TourneyList::$status;
        return view('tournament.index', compact('tournamentList', 'tournamentStatus'));
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
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $tournament = $this->getCacheTournament('tournament', $id);
        $dataArr = [];

        if (!empty($tournament->matches)) {
            foreach ($tournament->matches as $match) {
                $dataArr['matches'][$match->round_id][] = $match;
                $dataArr['round'][$match->round_id] = $match->round;
            }
        }

        if (!empty($tournament->prize_pool)) {
            $prizePools = explode(",", $tournament->prize_pool);
            foreach ($prizePools as $key => $prize) {
                $dataArr['prizes'][$key] = $prize;
            }
            $key1 = array_search('$', $dataArr['prizes']);
            $key2 = array_search('', $dataArr['prizes']);
            if ($key1 !== false) {
                unset($dataArr['prizes'][$key1]);
            }
            if ($key2 !== false) {
                unset($dataArr['prizes'][$key2]);
            }
        }

        if (!empty($tournament->maps)) {
            $maps = explode(",", $tournament->maps);
            foreach ($maps as $key => $map_name) {
                $dataArr['maps'][$key] = ReplayMap::where('name', $map_name)->first(['name', 'url']);
            }
        }

        return view('tournament.show',
            compact('tournament', 'dataArr')
        );
    }

    public $ttl = 3600;

    private function getCacheTournament($cache_name, $id)
    {
        if (\Cache::has($cache_name) && !empty(\Cache::get($cache_name))) {
            $data_cache = \Cache::get($cache_name);
        } else {
            $data_cache = \Cache::remember($cache_name, $this->ttl, function () use ($cache_name, $id) {
                return $this->getTournament($id);
            });
        }
        return $data_cache;
    }

    private function getTournament($id)
    {
        $tournament = TourneyList::with(
            'admin_user',
            'matches',
            'win_player:id,tourney_id,user_id,check_in,description,place_result',

            'checkin_players:id,user_id,tourney_id,check_in,description,place_result',
            'checkin_players.user:id,avatar,name,country_id,race_id',
            'checkin_players.user.countries:id,name,flag',
            'checkin_players.user.races:id,title',

            'matches.player1:id,tourney_id,user_id',
            'matches.player1.user:id,avatar,name,country_id,race_id',
            'matches.player1.user.countries:id,name,flag',
            'matches.player1.user.races:id,title',

            'matches.player2:id,tourney_id,user_id',
            'matches.player2.user:id,avatar,name,country_id,race_id',
            'matches.player2.user.countries:id,name,flag',
            'matches.player2.user.races:id,title'

        )
            ->with(['checkin_players' => function ($query) {
                $query->orderByRaw("CAST(place_result as UNSIGNED) DESC");
            }])
            ->with(['matches' => function ($query) {
                $query->orderBy("round_id", 'ASC');
            }])
            ->findOrFail($id);

        return $tournament;
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
}
