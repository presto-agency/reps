<?php

namespace App\Services\Tournament;

class TourneyService
{

    /**
     * @param $tourney
     */
    public static function generateMatches($tourney)
    {
        function teamInTour($tour, $team)
        {
            foreach ($tour as $game) {
                if (in_array($team, $game)) {
                    return true;
                }
            }

            return false;
        }


        $playerCount = $tourney->players->count();

        $matches = [];
        $players = $tourney->players->shuffle();
        if (($playerCount & 1)) {
            $players[] = ['description' => '#UNKNOW#'];
        }
        for ($i = 0; $i < $playerCount / 2; $i++) {
            $matches[] = [$players[$i]['description'], $players[$playerCount / 2 + $i + 1]['description']];
        }

        dd($matches);
    }


    /**
     * @param  string  $prize_pool
     *
     * @return string
     */
    public static function getPrizePool(string $prize_pool)
    {
        $prize  = explode(",", $prize_pool);
        $length = count($prize);

        return TourneyService::prize_prefix($prize_pool).TourneyService::prizeSum($prize_pool).$prize[$length - 1];
    }

    /**
     * @param  string  $prize_pool
     *
     * @return array
     */
    public static function getPrize(string $prize_pool)
    {
        $prize      = explode(',', $prize_pool);
        $length     = count($prize);
        $prizeArray = [];
        for ($i = 1; $i < count($prize) - 1; $i++) {
            $prizeArray[] = $prize[0].$prize[$i].$prize[$length - 1];
        }

        return $prizeArray;
    }

    /**
     * @param $t
     * @param $p
     * @param $c
     * @param  string  $pf
     *
     * @return int
     */
    public static function TImportance($t, $p, $c, $pf = '')
    {
        If ($t == 0) {
            Return 0;
        }
        $imp = 0;
        If (($p >= 10) && ($p < 25)) {
            $imp += 1;
        }
        If (($p >= 25) && ($p < 100)) {
            $imp += 2;
        }
        If (($p >= 100) && ($p < 250)) {
            $imp += 4;
        }
        If (($p >= 250) && ($p < 1000)) {
            $imp += 7;
        }
        If (($p >= 1000) && ($p < 2500)) {
            $imp += 11;
        }
        If (($p >= 2500)) {
            $imp += 16;
        }

        If (($c >= 8) && ($c < 16)) {
            $imp += 1;
        }
        If (($c >= 16) && ($c < 32)) {
            $imp += 2;
        }
        If (($c >= 32) && ($c < 64)) {
            $imp += 3;
        }
        If (($c >= 64) && ($c < 128)) {
            $imp += 4;
        }
        If (($c >= 128) && ($c < 256)) {
            $imp += 5;
        }
        If (($c >= 256)) {
            $imp += 6;
        }

        Switch ($pf) {
            case 'cc':
                $imp = -1;
                break;
        }

        Return $imp;
    }

    /**
     * @param $prize_pool
     * @param $ranking
     * @param $playersCount
     *
     * @return string
     */
    public static function ImpToStars($prize_pool, $ranking, $playersCount)
    {
        $sum    = TourneyService::prizeSum($prize_pool);
        $prefix = TourneyService::prize_prefix($prize_pool);
        $imp    = TourneyService::TImportance($ranking, $sum, $playersCount, $prefix);
        $r      = '';
        $simp   = $imp;
        /** Special Tour Ranks */
        switch ($imp) {
            case -1:
                $r .= '<img src = "/images/icons/cc.png">';
                break;
        }
        /** --- */
        if ($imp == 0) {
            $r .= '<img title="'.$simp.'" src = "/images/icons/starsnone.png">';
        }
        while ($imp >= 4) {
            $r   .= '<img title="'.$simp
                .'" src = "/images/icons/stargold.png">';
            $imp -= 4;
        }
        for ($I = 1; $I <= $imp; $I++) {
            $r .= '<img title="'.$simp
                .'" src = "/images/icons/starsilver.png">';
        }

        return $r;
    }

    /**
     * @param $prize_pool
     *
     * @return int|mixed
     */
    public static function prizeSum($prize_pool)
    {
        $prize = explode(",", $prize_pool);
        $sum   = 0;
        for ($i = 1; $i < count($prize) - 1; $i++) {
            $sum += $prize[$i];
        }

        return $sum;
    }

    /**
     * @param $prize_pool
     *
     * @return mixed
     */
    public static function prize_prefix($prize_pool)
    {
        $prize = explode(",", $prize_pool);

        return $prize[0];
    }

}
