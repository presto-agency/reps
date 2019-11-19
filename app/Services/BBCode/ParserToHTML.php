<?php


namespace App\Services\BBCode;

use \ChrisKonnertz\BBCode\BBCode;

class ParserToHTML
{

    public static function toHTML($text, $ignoreTag)
    {
        $bbCode = new BBCode();
        $bbCode->ignoreTag($ignoreTag);
        return $bbCode->render($text);
    }
}
