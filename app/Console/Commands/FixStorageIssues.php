<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\PropertyImage;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Artisan;

class FixStorageIssues extends Command
{
    protected $signature = 'storage:fix-all {--force : Force recreate storage link}';
    protected $description = 'Fix all storage-related issues including links and image paths';

    public function handle()
    {
        $this->info('🔧 Starting comprehensive storage fix...');

        // Step 1: Check and fix storage link
        $this->fixStorageLink();

        // Step 2: Create necessary directories
        $this->createDirectories();

        // Step 3: Check file permissions
        $this->checkPermissions();

        // Step 4: Fix image paths in database
        $this->fixImagePaths();

        // Step 5: List current storage structure
        $this->showStorageStructure();

        $this->info('✅ Storage fix completed!');
        return 0;
    }

    private function fixStorageLink()
    {
        $this->info('📁 Checking storage link...');

        $linkPath = public_path('storage');
        $targetPath = storage_path('app/public');

        if ($this->option('force') && file_exists($linkPath)) {
            if (is_link($linkPath)) {
                unlink($linkPath);
                $this->info('🗑️  Removed existing storage link');
            } else {
                File::deleteDirectory($linkPath);
                $this->info('🗑️  Removed existing storage directory');
            }
        }

        if (!file_exists($linkPath)) {
            Artisan::call('storage:link');
            $this->info('🔗 Created storage link');
        } else {
            $this->info('✅ Storage link already exists');
        }

        // Verify the link works
        if (is_link($linkPath) && readlink($linkPath) === $targetPath) {
            $this->info('✅ Storage link is working correctly');
        } else {
            $this->error('❌ Storage link is not working properly');
        }
    }

    private function createDirectories()
    {
        $this->info('📂 Creating necessary directories...');

        $directories = [
            'property_images',
            'properties', 
            'uploads',
            'images',
            'temp'
        ];

        foreach ($directories as $dir) {
            if (!Storage::disk('public')->exists($dir)) {
                Storage::disk('public')->makeDirectory($dir);
                $this->info("📁 Created directory: {$dir}");
            }
        }
    }

    private function checkPermissions()
    {
        $this->info('🔐 Checking permissions...');

        $storagePath = storage_path('app/public');
        $publicStoragePath = public_path('storage');

        // Check storage directory permissions
        if (is_writable($storagePath)) {
            $this->info('✅ Storage directory is writable');
        } else {
            $this->error('❌ Storage directory is not writable');
            $this->info("Run: chmod -R 755 {$storagePath}");
        }

        // Check public storage link permissions
        if (file_exists($publicStoragePath) && is_readable($publicStoragePath)) {
            $this->info('✅ Public storage link is readable');
        } else {
            $this->error('❌ Public storage link is not accessible');
        }
    }

    private function fixImagePaths()
    {
        $this->info('🖼️  Fixing image paths in database...');

        $images = PropertyImage::all();
        $fixedCount = 0;
        $missingCount = 0;

        $this->output->progressStart($images->count());

        foreach ($images as $image) {
            $this->output->progressAdvance();

            $originalPath = $image->image_path;
            $cleanPath = ltrim($originalPath, '/');
            $cleanPath = str_replace('storage/', '', $cleanPath);

            // Check if current path exists
            if (Storage::disk('public')->exists($cleanPath)) {
                if ($image->image_path !== $cleanPath) {
                    $image->update(['image_path' => $cleanPath]);
                    $fixedCount++;
                }
                continue;
            }

            // Try to find the image in different locations
            $possiblePaths = [
                'property_images/' . basename($cleanPath),
                'properties/' . basename($cleanPath),
                'uploads/' . basename($cleanPath),
                'images/' . basename($cleanPath),
                basename($cleanPath)
            ];

            $found = false;
            foreach ($possiblePaths as $path) {
                if (Storage::disk('public')->exists($path)) {
                    $image->update(['image_path' => $path]);
                    $fixedCount++;
                    $found = true;
                    break;
                }
            }

            if (!$found) {
                $missingCount++;
            }
        }

        $this->output->progressFinish();

        $this->info("\n📊 Image Path Fix Summary:");
        $this->info("Total images: " . $images->count());
        $this->info("Fixed paths: {$fixedCount}");
        $this->info("Missing files: {$missingCount}");
    }

    private function showStorageStructure()
    {
        $this->info("\n📋 Current storage structure:");

        $storagePath = storage_path('app/public');
        if (!is_dir($storagePath)) {
            $this->error("Storage directory doesn't exist: {$storagePath}");
            return;
        }

        $this->listDirectory($storagePath, 0, 2);

        // Show some sample image URLs
        $this->info("\n🔗 Sample image URLs:");
        $sampleImages = PropertyImage::take(3)->get();
        foreach ($sampleImages as $image) {
            $this->line("ID {$image->id}: {$image->image_url}");
        }
    }

    private function listDirectory($path, $depth, $maxDepth)
    {
        if ($depth > $maxDepth) {
            return;
        }

        $items = File::glob($path . '/*');
        $indent = str_repeat('  ', $depth);

        foreach ($items as $item) {
            $name = basename($item);
            if (is_dir($item)) {
                $fileCount = count(File::files($item));
                $this->line("{$indent}📁 {$name}/ ({$fileCount} files)");
                $this->listDirectory($item, $depth + 1, $maxDepth);
            }
        }

        if ($depth === 0) {
            $totalFiles = count(File::allFiles($path));
            $this->line("{$indent}📊 Total files in storage: {$totalFiles}");
        }
    }
}
