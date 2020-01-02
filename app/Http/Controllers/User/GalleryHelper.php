<?php


namespace App\Http\Controllers\User;


use App\Models\Comment;
use App\Models\UserGallery;

class GalleryHelper
{

    public static function getAllUserImagesAjaxId($row, $user_id, $id)
    {
        return UserGallery::where('user_id', $user_id)
            ->where('id', '<', $id)
            ->orderByDesc('id')
            ->limit(8)
            ->get($row);
    }


    /**
     * @param $row
     *
     * @return mixed
     */
    public static function getGalleriesImagesAjax($row)
    {
        return UserGallery::orderByDesc('id')->limit(8)->get($row);
    }

    public static function getGalleriesImagesAjaxId($row, $id)
    {
        return UserGallery::orderByDesc('id')->where('id', '<', $id)->limit(8)
            ->get($row);
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

}
