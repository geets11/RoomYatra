<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SubadminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create subadmin user
        $subadmin = User::create([
            'name' => 'Subadmin User',
            'email' => 'subadmin@gmail.com',
            'phone' => '9876543210',
            'password' => Hash::make('subadmin123'),
        ]);

        // Assign subadmin role
        $subadmin->assignRole('subadmin');

        // Assign specific permissions
        $subadmin->givePermissionTo([
            'assist admin',
            'review listing',
            'handle complain'
        ]);
    }
}
