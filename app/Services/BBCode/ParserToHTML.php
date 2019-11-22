<?php


namespace App\Services\BBCode;

use ChrisKonnertz\BBCode\BBCode;

class ParserToHTML
{

    /**
     * @param $text
     * @param $ignoreTag
     *
     * @return string
     */
    public static function toHTML($text, $ignoreTag = null)
    {
        $bbCode = new BBCode();
        if ( ! empty($ignoreTag)) {
            $bbCode->ignoreTag($ignoreTag);
        }

        return htmlspecialchars_decode($bbCode->render($text));
    }

}
