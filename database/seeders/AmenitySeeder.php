<?php

namespace Database\Seeders;

use App\Models\Amenity;
use Illuminate\Database\Seeder;

class AmenitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $amenities = [
            // Basic amenities
            ['name' => 'Wi-Fi', 'icon' => 'wifi', 'category' => 'basic'],
            ['name' => 'TV', 'icon' => 'tv', 'category' => 'basic'],
            ['name' => 'Air Conditioning', 'icon' => 'wind', 'category' => 'basic'],
            ['name' => 'Heating', 'icon' => 'thermometer', 'category' => 'basic'],
            ['name' => 'Washing Machine', 'icon' => 'loader', 'category' => 'basic'],
            ['name' => 'Dryer', 'icon' => 'loader', 'category' => 'basic'],
            ['name' => 'Kitchen', 'icon' => 'coffee', 'category' => 'basic'],
            ['name' => 'Refrigerator', 'icon' => 'box', 'category' => 'basic'],
            ['name' => 'Microwave', 'icon' => 'box', 'category' => 'basic'],
            ['name' => 'Dishwasher', 'icon' => 'droplet', 'category' => 'basic'],

            // Safety amenities
            ['name' => 'Smoke Alarm', 'icon' => 'alert-triangle', 'category' => 'safety'],
            ['name' => 'Carbon Monoxide Alarm', 'icon' => 'alert-triangle', 'category' => 'safety'],
            ['name' => 'Fire Extinguisher', 'icon' => 'alert-triangle', 'category' => 'safety'],
            ['name' => 'First Aid Kit', 'icon' => 'heart', 'category' => 'safety'],
            ['name' => 'Security Camera', 'icon' => 'video', 'category' => 'safety'],

            // Convenience amenities
            ['name' => 'Free Parking', 'icon' => 'truck', 'category' => 'convenience'],
            ['name' => 'Gym', 'icon' => 'activity', 'category' => 'convenience'],
            ['name' => 'Pool', 'icon' => 'droplet', 'category' => 'convenience'],
            ['name' => 'Hot Tub', 'icon' => 'droplet', 'category' => 'convenience'],
            ['name' => 'Elevator', 'icon' => 'arrow-up', 'category' => 'convenience'],
            ['name' => 'Wheelchair Accessible', 'icon' => 'user', 'category' => 'convenience'],
            ['name' => 'Balcony', 'icon' => 'home', 'category' => 'convenience'],
            ['name' => 'Garden', 'icon' => 'feather', 'category' => 'convenience'],
            ['name' => 'BBQ Grill', 'icon' => 'thermometer', 'category' => 'convenience'],
        ];

        foreach ($amenities as $amenity) {
            Amenity::create($amenity);
        }
    }
}
