<?php


namespace App\Services\ServiceAssistants;


class PathHelper
{
    /**
     * @param $storage
     * @return bool
     */
    public static function checkUploadStoragePath($storage)
    {
        \Storage::disk('public')->exists($storage) === false ? \Storage::disk('public')->makeDirectory($storage) : null;
        return 'storage' . $storage;
    }
}
