<?php
/**
 * Created by PhpStorm.
 * User: MAX
 * Date: 31.10.2019
 * Time: 13:08
 */

namespace App\Services\Base;


class RegexService
{
    /**
     * @param string $regex_name
     * @return string
     */
    public static function regex(string $regex_name)
    {
        switch ($regex_name) {
            case 'name':
                return '/^[\p{L}0-9,.)\-_\s]+$/u';
                break;
            case 'skype':
                return '/^[a-z][a-z0-9\.,\-_\:]{5,31}$/i';
                break;
            case 'url':
                return '/^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/';
                break;

        }
    }

}
