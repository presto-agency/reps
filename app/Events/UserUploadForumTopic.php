<?php


namespace App\Events;

use App\Models\ForumTopic;
use Illuminate\Queue\SerializesModels;


class UserUploadForumTopic
{

    use SerializesModels;

    public $userForumTopic;


    public function __construct(ForumTopic $userForumTopic)
    {
        $this->userForumTopic = $userForumTopic;
    }

}
