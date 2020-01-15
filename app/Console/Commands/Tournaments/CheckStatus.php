<?php

namespace App\Console\Commands\Tournaments;

use App\Models\TourneyList;
use Carbon\Carbon;
use Illuminate\Console\Command;

class CheckStatus extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tourney:check';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
//        $this->updateTourney('reg_time', 'ANNOUNCE', 'REGISTRATION');
//        $this->updateTourney('checkin_time', 'REGISTRATION', 'CHECK-IN');

        //        $this->updateTourney('start_time', 'CHECK-IN', 'STARTED');
        //        if (isset($tourneyReg) && $tourneyReg->isNotEmpty()) {
        //            $tourneyReg;
        //
        //        }
    }


    //    /**
    //     * Change status from
    //     *
    //     * @param  string  $time_column_name
    //     * @param  string  $find_Status
    //     * @param  string  $new_status
    //     *
    //     * @return int
    //     */


    private function updateTourney(string $time_column_name, string $find_Status, string $new_status)
    {
        return TourneyList::query()
            ->where('status', array_search($find_Status, TourneyList::$status))
            ->whereNotNull($time_column_name)
            ->where($time_column_name, '<=', Carbon::now())
            //            ->get();
            ->update(['status' => array_search($new_status, TourneyList::$status)]);
    }

}
