<?php


namespace App\Services\BBCode;


use ChrisKonnertz\BBCode\BBCode as ChrisKonnertzBBCode;
use PheRum\BBCode\Facades\BBCode as PheRumBBCode;

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
        $bbCode = new ChrisKonnertzBBCode();
        $first_conversion = PheRumBBCode::parse($text);

        $bbCode->addTag('quote-shell', function ($tag, &$html, $openingTag) {
            if ($tag->opening) {
                return '<div class="comments__wrapp wrapp_comments">';
            }
            //            else {
            //                return '</div>';
            //            }
        });
        $bbCode->addTag('spoiler-shell', function ($tag, &$html, $openingTag) {
            if ($tag->opening) {
                return '<div class="bbSpoiler">'.'<a href="#" onclick="return xbbSpoiler(this)">'.'<strong>Show Spoiler</strong>'.'<strong style="display:none">Hide Spoiler</strong>'.'</a>'
                    .'<div class="spoiler" style="display:none">';
            } else {
                return '</div>'.'</div>';
            }
        });

        $second_conversion = $bbCode->render($first_conversion);


        $third_transformation = html_entity_decode($second_conversion);
        return $third_transformation;
    }

}
