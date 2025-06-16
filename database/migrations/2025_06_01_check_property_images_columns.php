<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Check existing columns
        $columns = Schema::getColumnListing('property_images');
        
        Schema::table('property_images', function (Blueprint $table) use ($columns) {
            // Only add sort_order if it doesn't exist
            if (!in_array('sort_order', $columns)) {
                $table->integer('sort_order')->default(0)->after('is_primary');
            }
            
            // Only add alt_text if it doesn't exist
            if (!in_array('alt_text', $columns)) {
                $table->string('alt_text')->nullable()->after('sort_order');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('property_images', function (Blueprint $table) {
            // Check if columns exist before dropping
            if (Schema::hasColumn('property_images', 'alt_text')) {
                $table->dropColumn('alt_text');
            }
            
            if (Schema::hasColumn('property_images', 'sort_order')) {
                $table->dropColumn('sort_order');
            }
        });
    }
};
