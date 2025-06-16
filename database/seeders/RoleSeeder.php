<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create roles
        $adminRole = Role::create(['name' => 'admin']);
        $subadminRole = Role::create(['name' => 'subadmin']);
        $landlordRole = Role::create(['name' => 'landlord']);
        $tenantRole = Role::create(['name' => 'tenant']);

        // Create permissions
        $manageUsers = Permission::create(['name' => 'manage users']);
        $manageProperties = Permission::create(['name' => 'manage properties']);
        $manageBookings = Permission::create(['name' => 'manage bookings']);
        $viewReports = Permission::create(['name' => 'view reports']);
        $manageSupport = Permission::create(['name' => 'manage support']);
        $createProperty = Permission::create(['name' => 'create property']);
        $bookProperty = Permission::create(['name' => 'book property']);

        // New subadmin specific permissions
        $assistAdmin = Permission::create(['name' => 'assist admin']);
        $reviewListing = Permission::create(['name' => 'review listing']);
        $handleComplain = Permission::create(['name' => 'handle complain']);

        // Assign permissions to roles
        $adminRole->givePermissionTo([
            'manage users',
            'manage properties',
            'manage bookings',
            'view reports',
            'manage support',
            'assist admin',
            'review listing',
            'handle complain'
        ]);

        $subadminRole->givePermissionTo([
            'manage users',
            'manage properties',
            'manage bookings',
            'manage support',
            'assist admin',
            'review listing',
            'handle complain'
        ]);

        $landlordRole->givePermissionTo([
            'create property',
            'manage properties'
        ]);

        $tenantRole->givePermissionTo([
            'book property'
        ]);
    }
}
