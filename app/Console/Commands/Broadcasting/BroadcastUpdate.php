<?php


namespace App\Console\Commands\Broadcasting;


use App\Models\Stream;
use App\Services\Broadcasting\Watcher;
use Carbon\Carbon;
use Illuminate\Console\Command;

class BroadcastUpdate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'broadcast:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add chanel and source';

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
     * @param  Watcher  $watcher
     */
    public function handle(Watcher $watcher)
    {
        foreach (Stream::all() as $stream) {
            $stream->updated_at = Carbon::now();
            $stream->save();
        }
    }
}
