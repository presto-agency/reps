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
        $data = $bbCode->render($text);
        $data1 = htmlspecialchars_decode($data);
//        html_entity_decode()
//        return
        return clean($data1);
    }

}
