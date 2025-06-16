<?php

namespace Database\Seeders;

use App\Models\PropertyType;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
class PropertyTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $types = [
            ['name' => 'Room', 'description' => 'A single room for rent'],
            ['name' => 'Studio', 'description' => 'A studio apartment'],
            ['name' => 'Apartment', 'description' => 'An apartment with one or more bedrooms'],
            ['name' => 'House', 'description' => 'A full house for rent'],
            ['name' => 'Hostel', 'description' => 'A hostel accommodation'],
            ['name' => 'Flat', 'description' => 'A flat for rent'],
            ['name' => 'Townhouse', 'description' => 'A townhouse for rent'],
            ['name' => 'Villa', 'description' => 'A villa for rent'],
            ['name' => 'Cottage', 'description' => 'A cottage for rent'],
        ];

        foreach ($types as $type) {
            PropertyType::create([
                'name'=> $type['name'],
                'description'=> $type['description'],
                'slug'=> Str::slug($type['name']),
            ]);
        }
    }
}
