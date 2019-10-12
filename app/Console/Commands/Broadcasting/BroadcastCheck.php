<?php

namespace App\Console\Commands\Broadcasting;

use App\Services\Broadcasting\GoodGame;
use App\Services\Broadcasting\Twitch;
use Illuminate\Console\Command;

class BroadcastCheck extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reps:BroadcastCheck';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Checking broadcast channels using services(Broadcasting)';

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
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function handle()
    {
        $chanelName = 'Verloin';

        $goodGame = new GoodGame();
        $goodGame->getStatus($chanelName);

        $chanelName = 'helix';
        $twitch = new Twitch();
        $twitch->getStatus($chanelName);

    }
}
