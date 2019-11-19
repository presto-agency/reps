<?php


namespace App\Services\ServiceAssistants;


class PathHelper
{
    public static $path;

    public static function checkUploadsFileAndPath($storagePath, $oldFilePath = null)
    {
        /*Check path*/
        \Storage::disk('public')->exists($storagePath) === false ? \Storage::disk('public')->makeDirectory($storagePath) : null;
        if (!empty($oldFilePath)) {
            /*Check old file*/
            if (strpos($oldFilePath, '/storage') !== false) {
                self::$path = \Str::replaceFirst('/storage', 'public', $oldFilePath);
            }
            if (strpos($oldFilePath, 'storage') !== false) {
                self::$path = \Str::replaceFirst('storage', 'public', $oldFilePath);
            }
            if (\Storage::exists(self::$path)) {
                \Storage::delete(self::$path);
            }
        }

        return $storagePath;
    }

    public static function checkFileExists($path)
    {
        return $path;
    }
}
