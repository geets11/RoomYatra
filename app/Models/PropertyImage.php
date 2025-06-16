<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class PropertyImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'property_id',
        'image_path',
        'is_primary',
        'sort_order',
        'alt_text'
    ];

    protected $casts = [
        'is_primary' => 'boolean',
        'sort_order' => 'integer'
    ];

    /**
     * Get the property that owns the image.
     */
    public function property()
    {
        return $this->belongsTo(Property::class);
    }

    /**
     * Get the full URL for the image
     */
    public function getImageUrlAttribute()
    {
        if (empty($this->image_path)) {
            return $this->getPlaceholderUrl();
        }

        // If it's already a full URL, return it
        if (filter_var($this->image_path, FILTER_VALIDATE_URL)) {
            return $this->image_path;
        }

        // Clean the path - remove any leading slashes or 'storage/' prefix
        $cleanPath = ltrim($this->image_path, '/');
        $cleanPath = str_replace('storage/', '', $cleanPath);

        // Try different possible locations
        $possiblePaths = [
            $cleanPath,
            'property_images/' . basename($cleanPath),
            'properties/' . basename($cleanPath),
            'uploads/' . basename($cleanPath),
            'images/' . basename($cleanPath),
        ];

        foreach ($possiblePaths as $path) {
            if (Storage::disk('public')->exists($path)) {
                return asset('storage/' . $path);
            }
        }

        // Check if file exists in public directory directly
        $publicPaths = [
            'storage/' . $cleanPath,
            'images/' . basename($cleanPath),
            'uploads/' . basename($cleanPath),
        ];

        foreach ($publicPaths as $path) {
            if (file_exists(public_path($path))) {
                return asset($path);
            }
        }

        Log::warning("Image not found: {$this->image_path} for property image ID {$this->id}");
        return $this->getPlaceholderUrl();
    }

    /**
     * Get placeholder image URL
     */
    private function getPlaceholderUrl()
    {
        // Check if custom placeholder exists
        if (file_exists(public_path('images/placeholder-property.jpg'))) {
            return asset('images/placeholder-property.jpg');
        }

        // Use a reliable placeholder service
        return 'https://images.unsplash.com/photo-1560518883-ce09059eeffa?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&h=300&q=80';
    }

    /**
     * Check if the image file exists
     */
    public function getExistsAttribute()
    {
        if (empty($this->image_path)) {
            return false;
        }

        $cleanPath = ltrim($this->image_path, '/');
        $cleanPath = str_replace('storage/', '', $cleanPath);

        return Storage::disk('public')->exists($cleanPath);
    }

    /**
     * Get the full file system path
     */
    public function getFullPathAttribute()
    {
        if (empty($this->image_path)) {
            return null;
        }

        $cleanPath = ltrim($this->image_path, '/');
        $cleanPath = str_replace('storage/', '', $cleanPath);

        return storage_path('app/public/' . $cleanPath);
    }

    /**
     * Scope to get primary images
     */
    public function scopePrimary($query)
    {
        return $query->where('is_primary', true);
    }

    /**
     * Scope to get images ordered by sort order
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('created_at');
    }
}
