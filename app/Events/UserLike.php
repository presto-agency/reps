<?php


namespace App\Events;


use App\Models\UserReputation;
use Illuminate\Queue\SerializesModels;


class UserLike
{

    use SerializesModels;

    public $userReputation;


    public function __construct(UserReputation $userReputation)
    {
        $this->userReputation = $userReputation;
    }

}
