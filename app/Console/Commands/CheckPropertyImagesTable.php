<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CheckPropertyImagesTable extends Command
{
    protected $signature = 'check:property-images-table';
    protected $description = 'Check the structure of property_images table';

    public function handle()
    {
        $this->info('Property Images Table Structure:');
        $this->line('=====================================');
        
        // Get column listing
        $columns = Schema::getColumnListing('property_images');
        $this->info('Columns: ' . implode(', ', $columns));
        
        // Get detailed structure
        $structure = DB::select('DESCRIBE property_images');
        
        $this->table(
            ['Field', 'Type', 'Null', 'Key', 'Default', 'Extra'],
            collect($structure)->map(function ($column) {
                return [
                    $column->Field,
                    $column->Type,
                    $column->Null,
                    $column->Key,
                    $column->Default,
                    $column->Extra
                ];
            })->toArray()
        );
        
        return 0;
    }
}
