<?php


namespace App\Http\Controllers\User;


use App\Models\Comment;
use App\Models\UserGallery;

class GalleryHelper
{

    /**
     * UserImages
     */


    /**
     * @param $row
     * @param $user_id
     * @return mixed
     */
    public static function getAllUserImagesAjax($row, $user_id)
    {
        return UserGallery::
        where('user_id', $user_id)
            ->orderByDesc('id')
            ->limit(8)
            ->get($row);
    }

    public static function getAllUserImagesAjaxId($row, $user_id, $id)
    {
        return UserGallery::where('user_id', $user_id)
            ->where('id', '<', $id)
            ->orderByDesc('id')
            ->limit(8)
            ->get($row);
    }

    public static function getUserImage($id, $relation, $row)
    {
        return UserGallery::with($relation)->select($row)->findOrFail($id);
    }

    public static function previousUserImage($id, $relation, $row)
    {
        return UserGallery::with($relation)
            ->select($row)
            ->where('user_id', auth()->id())
            ->where('id', '<', $id)
            ->max('id');
    }

    public static function nextUserImage($id, $relation, $row)
    {
        return UserGallery::with($relation)
            ->select($row)
            ->where('user_id', auth()->id())
            ->where('id', '>', $id)
            ->min('id');
    }

    /**
     * @param $row
     * @return mixed
     */
    public static function getGalleriesImagesAjax($row)
    {
        return UserGallery::orderByDesc('id')->limit(8)->get($row);
    }

    public static function getGalleriesImagesAjaxId($row, $id)
    {
        return UserGallery::orderByDesc('id')->where('id', '<', $id)->limit(8)->get($row);
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

    public function saveComments()
    {
        $request = request();
        $replay = UserGallery::findOrFail($request->id);
        $comment = new Comment([
            'user_id' => auth()->id(),
            'content' => $request->input('content')
        ]);
        $replay->comments()->save($comment);

        return back();
    }
}
