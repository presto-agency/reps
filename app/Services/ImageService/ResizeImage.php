<?php


namespace App\Services\ImageService;


use Intervention\Image\Facades\Image;

class ResizeImage
{

    /**
     * Resize image
     *
     * @param $fileName
     * @param $originPath
     * @return mixed
     */
    public static function resizeFlagImage25x20($fileName,$originPath)
    {
        $newPath = "storage/images/countries/flags/25x20/";
        self::checkUploadPath($newPath);
        $ext = ".png";
        $path = $newPath . $fileName . $ext;
        $resizeImg = Image::make($originPath)->resize(25, 20)->save($path, 100);

        return $resizeImg;
    }

    /**
     * @param $save_path
     * @return bool
     */
    public static function checkUploadPath($save_path)
    {
        return !\File::exists($save_path) === true ? mkdir($save_path, 666, true) : null;
    }
}
