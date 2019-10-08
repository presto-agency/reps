<?php


namespace App\Events;


use App\Models\Comment;
use Illuminate\Queue\SerializesModels;


class UserComment
{

    use SerializesModels;

    public $userComment;


    public function __construct(Comment $userComment)
    {
        $this->userComment = $userComment;
    }

}
