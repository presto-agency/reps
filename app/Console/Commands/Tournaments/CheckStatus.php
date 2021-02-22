<?php

namespace App\Console\Commands\Tournaments;

use App\Models\TourneyList;
use Carbon\Carbon;
use Exception;
use Illuminate\Console\Command;
use Log;

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

    public function handle()
    {
        self::updateTourney('reg_time', 'ANNOUNCE', 'REGISTRATION');
        self::updateTourney('checkin_time', 'REGISTRATION', 'CHECK-IN');
        self::updateTourney('start_time', 'CHECK-IN', 'STARTED');
    }


    private static function updateTourney(string $time_column_name, string $old_status, string $new_status)
    {
        try {
            return TourneyList::query()
                ->where('status', array_search($old_status, TourneyList::$status))
                ->whereNotNull($time_column_name)
                ->where($time_column_name, '<=', Carbon::now())
                ->update(['status' => array_search($new_status, TourneyList::$status)]);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return null;
        }

    }

}
