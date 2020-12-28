<?php


namespace App\Console\Commands\Broadcasting;


use App\Models\Stream;
use App\Services\Broadcasting\Watcher;
use Illuminate\Console\Command;

class BroadcastWatcher extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'broadcast:watch';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Watching streams by endpoints';

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
        try {
            $defiler = $watcher->getData('defiler');
            if (!is_null($defiler)) {
                Stream::createFromBroadcastWatch($defiler);
            }
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
        }

    }
}
