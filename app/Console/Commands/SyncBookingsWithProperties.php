<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Property;
use App\Models\Booking;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class SyncBookingsWithProperties extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bookings:sync';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Synchronize bookings with booked properties';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Starting synchronization of bookings with properties...');
        
        // Get all properties with status 'booked'
        $bookedProperties = Property::where('status', 'booked')->get();
        $this->info("Found {$bookedProperties->count()} properties with 'booked' status.");
        
        $createdCount = 0;
        
        foreach ($bookedProperties as $property) {
            // Check if a booking exists for this property
            $bookingExists = Booking::where('property_id', $property->id)
                ->where('status', 'approved')
                ->exists();
            
            if (!$bookingExists) {
                // Find a tenant user
                $tenant = User::where('role', 'tenant')->first();
                
                if ($tenant) {
                    // Create a new booking for this property
                    $booking = new Booking();
                    $booking->property_id = $property->id;
                    $booking->user_id = $tenant->id;
                    $booking->status = 'approved';
                    $booking->check_in = now();
                    $booking->save();
                    
                    $this->info("Created booking #{$booking->id} for property #{$property->id}");
                    $createdCount++;
                } else {
                    $this->warn("No tenant user found to create booking for property #{$property->id}");
                }
            }
        }
        
        // Also check for any approved bookings without booked properties
        $approvedBookings = Booking::where('status', 'approved')->get();
        $updatedCount = 0;
        
        foreach ($approvedBookings as $booking) {
            if ($booking->property && $booking->property->status != 'booked') {
                $booking->property->status = 'booked';
                $booking->property->save();
                
                $this->info("Updated property #{$booking->property_id} status to 'booked' for booking #{$booking->id}");
                $updatedCount++;
            }
        }
        
        $this->info("Synchronization complete. Created {$createdCount} bookings and updated {$updatedCount} properties.");
        
        return 0;
    }
}
