<?php


namespace App\Http\Controllers\User;


use App\Models\UserGallery;

class GalleryHelper
{

    /**
     * UserImages
     */


    /**
     * @param $row
     * @return mixed
     */
    public static function getAllUserImages($row)
    {
        return UserGallery::where('user_id', auth()->user()->id)->get($row);
    }

    public static function getUserImage($id, $relation, $row)
    {
        return UserGallery::with($relation)->select($row)->findOrFail($id);
    }

    public static function previousUserImage($id, $relation, $row)
    {
        return UserGallery::with($relation)
            ->select($row)
            ->where('user_id', auth()->user()->id)
            ->where('id', '<', $id)
            ->max('id');
    }

    public static function nextUserImage($id, $relation, $row)
    {
        return UserGallery::with($relation)
            ->select($row)
            ->where('user_id', auth()->user()->id)
            ->where('id', '>', $id)
            ->min('id');
    }

    /**
     * GalleriesImages
     */

    public static function getGalleriesImages($row)
    {
        return UserGallery::all($row);
    }

    public static function previousGalleriesImage($id, $relation, $row)
    {
        return UserGallery::with($relation)
            ->select($row)
            ->where('id', '<', $id)
            ->max('id');
    }

    public static function nextGalleriesImage($id, $relation, $row)
    {
        return UserGallery::with($relation)
            ->select($row)
            ->where('id', '>', $id)
            ->min('id');
    }


    public static function getUrl()
    {
        return collect(request()->segments());
    }

    public static function checkUrlGalleries()
    {
        return \Str::contains(self::getUrl(), 'galleries');
    }

}
