<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class ImageHelper
{
    /**
     * Save an uploaded image to storage.
     *
     * @param \Illuminate\Http\UploadedFile $image
     * @param string $directory
     * @param string|null $oldImage
     * @return string
     */
    public static function saveImage($image, $directory = 'property_images', $oldImage = null)
    {
        // Delete old image if it exists
        if ($oldImage && Storage::disk('public')->exists($oldImage)) {
            Storage::disk('public')->delete($oldImage);
        }

        // Generate a unique filename
        $filename = Str::uuid() . '.' . $image->getClientOriginalExtension();
        $path = $directory . '/' . $filename;

        // Store the image
        Storage::disk('public')->put($path, file_get_contents($image));

        return $path;
    }

    /**
     * Get the URL for an image path.
     *
     * @param string|null $path
     * @param string $default
     * @return string
     */
    public static function getImageUrl($path, $default = 'images/placeholder.jpg')
    {
        if (empty($path)) {
            return asset($default);
        }

        // Check if the path is already a URL
        if (filter_var($path, FILTER_VALIDATE_URL)) {
            return $path;
        }

        // Check if the image exists in storage
        if (Storage::disk('public')->exists($path)) {
            return Storage::url($path);
        }

        // Try alternative paths
        $variations = [
            'property_images/' . basename($path),
            'properties/' . basename($path),
            'images/' . basename($path),
            basename($path)
        ];

        foreach ($variations as $variation) {
            if (Storage::disk('public')->exists($variation)) {
                return Storage::url($variation);
            }
        }

        return asset($default);
    }

    /**
     * Check if an image exists.
     *
     * @param string|null $path
     * @return bool
     */
    public static function imageExists($path)
    {
        if (empty($path)) {
            return false;
        }

        // Check if the path is a URL
        if (filter_var($path, FILTER_VALIDATE_URL)) {
            $headers = @get_headers($path);
            return $headers && strpos($headers[0], '200') !== false;
        }

        // Check if the image exists in storage
        if (Storage::disk('public')->exists($path)) {
            return true;
        }

        // Try alternative paths
        $variations = [
            'property_images/' . basename($path),
            'properties/' . basename($path),
            'images/' . basename($path),
            basename($path)
        ];

        foreach ($variations as $variation) {
            if (Storage::disk('public')->exists($variation)) {
                return true;
            }
        }

        return false;
    }
}
