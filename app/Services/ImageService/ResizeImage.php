<?php


namespace App\Services\ImageService;

use Image;
use Storage;
use Str;


class ResizeImage
{

    /**
     * @param $imageFile
     * @param $width
     * @param $height
     * @param $aspectRatio
     * @param $path
     * @param  bool  $encode
     *
     * @return string
     */
    public static function resizeImg($imageFile, $width, $height, $aspectRatio, $path, $encode = false)
    {
        if (method_exists($imageFile, 'getClientOriginalExtension')) {
            $ext = $imageFile->getClientOriginalExtension();
        } elseif (method_exists($imageFile, 'getExtension')) {
            $ext = $imageFile->getExtension();
        }


        self::checkPath($path);

        if ($aspectRatio) {
            $aspectRatio = function ($constraint) {
                $constraint->aspectRatio();
            };
        } else {
            $aspectRatio = null;
        }
        // open an image_1 file -> now you are able to resize the instance -> finally we save the image_1 as a new file

        $openImage = Image::make($imageFile);
        $openImage->resize($width, $height, $aspectRatio);

        if ($encode) {
            $openImage->encode('png', 100);
            $ext = 'png';
        }

        $fullPath = "storage/{$path}".Str::random(32).".{$ext}";

        $openImage->save($fullPath, 100);


        return $fullPath;
    }

    /**
     *  Check path
     *
     * @param  string  $path
     */
    public static function checkPath(string $path)
    {
        Storage::disk('public')->exists($path) === false
            ? Storage::disk('public')->makeDirectory($path) : null;
    }

}
