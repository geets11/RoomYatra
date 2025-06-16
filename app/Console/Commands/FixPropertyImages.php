<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Property;
use App\Models\PropertyImage;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;

class FixPropertyImages extends Command
{
    protected $signature = 'property:fix-images {--force : Force update all image paths}';
    protected $description = 'Check and fix property image paths';

    public function handle()
    {
        $this->info('Checking property images...');

        // Check storage link
        if (!file_exists(public_path('storage'))) {
            $this->warn('Storage link not found! Creating it now...');
            $this->call('storage:link');
        }

        // Create necessary directories if they don't exist
        $directories = ['property_images', 'properties', 'images'];
        foreach ($directories as $dir) {
            if (!Storage::disk('public')->exists($dir)) {
                Storage::disk('public')->makeDirectory($dir);
                $this->info("Created directory: {$dir}");
            }
        }

        $images = PropertyImage::all();
        $fixedCount = 0;
        $missingCount = 0;
        $forceUpdate = $this->option('force');

        $this->output->progressStart($images->count());

        foreach ($images as $image) {
            $this->output->progressAdvance();
            
            // Skip if image exists and we're not forcing updates
            if (!$forceUpdate && Storage::disk('public')->exists($image->image_path)) {
                continue;
            }

            // Check if image exists
            if (!Storage::disk('public')->exists($image->image_path)) {
                $missingCount++;

                // Try to find the image with different path variations
                $variations = [
                    'property_images/' . basename($image->image_path),
                    'properties/' . basename($image->image_path),
                    'images/' . basename($image->image_path),
                    basename($image->image_path)
                ];

                $found = false;
                foreach ($variations as $variation) {
                    if (Storage::disk('public')->exists($variation)) {
                        $image->update(['image_path' => $variation]);
                        $fixedCount++;
                        $found = true;
                        break;
                    }
                }

                if (!$found) {
                    // Log the missing image
                    Log::warning("Missing image: {$image->image_path} for property ID {$image->property_id}");
                }
            }
        }

        $this->output->progressFinish();

        $this->info("\nSummary:");
        $this->info("Total images: " . $images->count());
        $this->info("Fixed: {$fixedCount}");
        $this->info("Still missing: " . ($missingCount - $fixedCount));

        // List storage contents
        $this->info("\nStorage directory structure:");
        $this->listDirectoryContents(storage_path('app/public'), 0);

        return 0;
    }

    /**
     * List directory contents recursively up to a certain depth
     */
    protected function listDirectoryContents($path, $depth, $maxDepth = 2)
    {
        if ($depth > $maxDepth) {
            return;
        }

        if (!is_dir($path)) {
            return;
        }

        $files = File::files($path);
        $directories = File::directories($path);

        $indent = str_repeat('  ', $depth);
        $relativePath = str_replace(storage_path('app/public'), '', $path);
        $this->line("{$indent}📁 {$relativePath} (" . count($files) . " files)");

        foreach ($directories as $directory) {
            $this->listDirectoryContents($directory, $depth + 1, $maxDepth);
        }
    }
}
