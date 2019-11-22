<?php

namespace App\Http\Controllers\Tournament;


use App\Models\ReplayMap;
use App\Models\TourneyList;
use App\Models\TourneyMatch;
use App\Services\Tournament\TourneyService;
use File;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Storage;
use Str;

class TournamentController extends Controller
{

    public $mapsIds;

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return view('tournament.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return redirect()->to('/');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function store(Request $request)
    {
        return redirect()->to('/');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     *
     * @return Response
     */
    public function show($id)
    {
        $tournament = $this->getTournament($id);
        $dataArr    = [];
        if (isset($tournament->maps) && ! empty($tournament->maps)) {
            $this->mapsIds = explode(",", $tournament->maps);
            foreach ($this->mapsIds as $key => $item) {
                $dataArr['mapsIds'][$key] = $item;
            }
        }
        $getMatchesMaps = ReplayMap::whereIn('id', $dataArr['mapsIds'])->get
        ([
            'name',
            'url',
        ]);
        if ( ! empty($tournament->matches)) {
            foreach ($tournament->matches as $match) {
                $dataArr['matches'][$match->round_id][]      = $match;
                $dataArr['round'][$match->round_id]['title'] = $match->round;
                $mapsCount
                                                             = count($this->mapsIds);
                $mapIndex                                    = $match->round_id
                    % $mapsCount;
                $map
                                                             = $this->getTourneyRoundMap($this->mapsIds[$mapIndex]);
                if ( ! empty($map)) {
                    $dataArr['round'][$match->round_id]['map']['name']
                        = $map->name;
                    $dataArr['round'][$match->round_id]['map']['url']
                        = $map->url;
                }
            }
        }

        $prizeList = TourneyService::getPrize($id);

        return view('tournament.show',
            compact('tournament', 'dataArr', 'prizeList', 'getMatchesMaps')
        );
    }

    public function getTourneyRoundMap($mapsId)
    {
        return ReplayMap::where('id', $mapsId)->first([
            'name',
            'url',
        ]);
    }


    //    public function downloadMultipleMatch($tournament)
    //    {
    //
    //    }

    public function downloadMatch($tourney,$match, $rep)
    {
        $tourneyMatchFile = TourneyMatch::where('tourney_id', $tourney)->where('match_id',$match)->value($rep);

        $repPath = $tourneyMatchFile;

        if (empty($repPath)) {
            return back();
        }
        if (strpos($tourneyMatchFile, '/storage') !== false) {
            $repPath = Str::replaceFirst('/storage', 'public',
                $tourneyMatchFile);
        }
        if (strpos($tourneyMatchFile, 'storage') !== false) {
            $repPath = Str::replaceFirst('storage', 'public',
                $tourneyMatchFile);
        }

        $checkPath = Storage::path($repPath);
        if (File::exists($checkPath) === false) {
            return back();
        };

        return response()->download($checkPath);
    }

    public function getTournament($id)
    {
        $tournament = TourneyList::with(

            'admin_user',
            'matches',
            'win_player:id,tourney_id,user_id,check_in,description,place_result',

            'players:id,user_id,tourney_id,check_in,description,place_result',
            'players.user:id,avatar,name,country_id,race_id',
            'players.user.countries:id,name,flag',
            'players.user.races:id,title',

            'matches.player1:id,tourney_id,user_id',
            'matches.player1.user:id,avatar,name,country_id,race_id',
            'matches.player1.user.countries:id,name,flag',
            'matches.player1.user.races:id,title',

            'matches.player2:id,tourney_id,user_id',
            'matches.player2.user:id,avatar,name,country_id,race_id',
            'matches.player2.user.countries:id,name,flag',
            'matches.player2.user.races:id,title'

        )
            ->with([
                'players' => function ($query) {
                    $query->orderBy('check_in', 'desc')
                        ->orderByRaw('LENGTH(place_result)')
                        ->orderBy('place_result');
                },
            ])
            ->with([
                'matches' => function ($query) {
                    $query->orderBy("round_id", 'ASC');
                },
            ])
            ->findOrFail($id);

        return $tournament;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     *
     * @return Response
     */
    public function edit($id)
    {
        return redirect()->to('/');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  int  $id
     *
     * @return Response
     */
    public function update(Request $request, $id)
    {
        return redirect()->to('/');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        return redirect()->to('/');
    }

    public function loadTournament()
    {
        if (request()->ajax()) {
            $visible_title = false;
            if (request('id') > 0) {
                $tournamentList = self::getTourneyListAjaxId(request('id'));
            } else {
                $tournamentList = self::getTourneyListAjax();
                $visible_title  = true;
            }
            $tournamentStatus = TourneyList::$status;
            $output           = view('tournament.components.index',
                compact('tournamentList', 'tournamentStatus', 'visible_title')
            );
            echo $output;
        }
    }

    public static function getTourneyListAjaxId($id)
    {
        return TourneyList::withCount('players')
            ->withCount('checkin_players')
            ->where('id', '<', $id)
            ->orderByDesc('id')
            ->limit(5)
            ->get();
    }

    public static function getTourneyListAjax()
    {
        return TourneyList::withCount('players')
            ->withCount('checkin_players')
            ->orderByDesc('id')
            ->limit(5)
            ->get();
    }

}
