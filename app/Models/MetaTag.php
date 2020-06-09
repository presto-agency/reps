<?php

namespace App\Models;

use File;
use Illuminate\Database\Eloquent\Model;
use Str;

class MetaTag extends Model
{

    protected $guarded
        = [
            'seo_title',
            'seo_keywords',
            'seo_description',
        ];

    /**
     * @return string
     */
    public function getMetaTitle(): string
    {
        return self::getMeta($this->seo_title ?? config('app.name', 'Reps.ru'));
    }

    /**
     * @param  string  $string
     *
     * @return string
     */
    public static function getMeta(string $string): string
    {
        return Str::limit($string, 65, '');
    }

    /**
     * @return string
     */
    public function getMetaKeywords(): string
    {
        return self::getMeta($this->seo_keywords ?? config('app.name', 'Reps.ru'));
    }

    /**
     * @return string
     */
    public function getMetaDescription(): string
    {
        return self::getMeta($this->seo_description ?? config('app.name', 'Reps.ru'));
    }

    /**
     * @return string
     */
    public function getMetaIcon(): string
    {
        return self::getMetaIconData()['path'];
    }

    public static function getMetaIconData()
    {
        $icon = asset('images/logo.png');

        return [
            'path' => $icon,
            'type' => 'image/'.File::extension($icon),
        ];
    }

    /**
     * @return string
     */
    public function getMetaIconType(): string
    {
        return self::getMetaIconData()['type'];
    }

}
