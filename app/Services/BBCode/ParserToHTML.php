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
//        $data = htmlspecialchars($bbCode->render($text));
        $data = $bbCode->render($text);
//        htmlspecialchars function to prevent XSS attacks.
        return clean(htmlspecialchars_decode($data));
    }

    public static function toHTML2($text, $ignoreTag = null)
    {
        $bbCode = new BBCode();
        if ( ! empty($ignoreTag)) {
            $bbCode->ignoreTag($ignoreTag);
        }
        //        $data = htmlspecialchars($bbCode->render($text));
        $data = $bbCode->render($text);
        //        htmlspecialchars function to prevent XSS attacks.
        return htmlspecialchars_decode($data);
    }
}
