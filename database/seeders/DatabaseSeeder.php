<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            AdminSeeder::class,
            SubadminSeeder::class,
            PropertyTypeSeeder::class,
            AmenitySeeder::class,
            SupportTicketSeeder::class, // Add this line
        ]);
    }
}
