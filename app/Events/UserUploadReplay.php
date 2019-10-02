<?php


namespace App\Events;


use App\Models\Replay;
use Illuminate\Queue\SerializesModels;


class UserUploadReplay
{

    use SerializesModels;

    public $userReplay;


    public function __construct(Replay $userReplay)
    {
        $this->userReplay = $userReplay;
    }

}
