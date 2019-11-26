<?php


namespace App\Services\ServiceAssistants;


use Storage;
use Str;

class PathHelper
{

    public static $path;
    public static $checkPath;

    public static function checkUploadsFileAndPath(
        $storagePath,
        $oldFilePath = null
    ) {
        /*Check path*/
        Storage::disk('public')->exists($storagePath) === false
            ? Storage::disk('public')->makeDirectory($storagePath) : null;

        if ( ! empty($oldFilePath)) {
            self::$path = $oldFilePath;
            /*Check old file*/
            if (strpos($oldFilePath, '/storage') !== false) {
                self::$path = Str::replaceFirst('/storage', 'public',
                    $oldFilePath);
            }
            if (strpos($oldFilePath, 'storage') !== false) {
                self::$path = Str::replaceFirst('storage', 'public',
                    $oldFilePath);
            }

            if (Storage::exists(self::$path)) {
                Storage::delete(self::$path);
            }
        }

        return $storagePath;
    }

    public static function checkFileExists($path)
    {
        self::$checkPath = $path;
        /*Check file*/

        if (strpos($path, '/storage') !== false) {
            self::$checkPath = Str::replaceFirst('/storage', 'public', $path);
        }
        if (strpos($path, 'storage') !== false) {
            self::$checkPath = Str::replaceFirst('storage', 'public', $path);
        }

        return Storage::exists(self::$checkPath);

    }

}
