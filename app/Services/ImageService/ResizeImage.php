<?php


namespace App\Services\ImageService;

use Image;
use Str;


class ResizeImage
{

    /**
     * @param $imageFile
     * @param $width
     * @param $height
     * @param $aspectRatio
     * @param $path
     *
     * @return string
     */
    public static function resizeImg($imageFile, $width, $height, $aspectRatio, $path)
    {
        $ext         = $imageFile->getClientOriginalExtension();
        $newFileName = Str::random(32);
        $savePath    = 'storage/'.$path.'/'.$newFileName.'.'.$ext;

        if ($aspectRatio === true) {
            $aspectRatio = function ($constraint) {
                $constraint->aspectRatio();
            };
        } else {
            $aspectRatio = null;
        }
        $openImage = Image::make($imageFile);

        // open an image_1 file -> now you are able to resize the instance -> finally we save the image_1 as a new file
        $openImage->resize($width, $height, $aspectRatio)->save($savePath, 100);

        return $savePath;
    }

}
