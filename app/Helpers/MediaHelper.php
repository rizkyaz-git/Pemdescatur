<?php

namespace App\Helpers;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class MediaHelper
{
    /**
     * Upload a new file and remove the previous file if it exists.
     */
    public static function replace(?UploadedFile $newFile, ?string $oldPath, string $directory = 'uploads', string $disk = 'public'): ?string
    {
        if (!$newFile) {
            return $oldPath;
        }

        self::delete($oldPath, $disk);

        return Storage::disk($disk)->putFile($directory, $newFile);
    }

    /**
     * Safely delete a file from the specified storage disk.
     */
    public static function delete(?string $path, string $disk = 'public'): bool
    {
        if ($path && Storage::disk($disk)->exists($path)) {
            return Storage::disk($disk)->delete($path);
        }

        return false;
    }
}
