<?php

namespace Database\Seeders;

use App\Models\SupportTicket;
use App\Models\User;
use Illuminate\Database\Seeder;

class SupportTicketSeeder extends Seeder
{
    public function run()
    {
        $users = User::whereIn('role', ['tenant', 'landlord'])->get();
        $subadmins = User::where('role', 'subadmin')->get();

        if ($users->count() > 0) {
            $tickets = [
                [
                    'subject' => 'Payment Issue',
                    'description' => 'Unable to process payment for booking. Card keeps getting declined.',
                    'status' => 'open',
                    'priority' => 'high'
                ],
                [
                    'subject' => 'Booking Cancellation',
                    'description' => 'Need to cancel my booking due to emergency. Please process refund.',
                    'status' => 'in_progress',
                    'priority' => 'urgent'
                ],
                [
                    'subject' => 'Account Access',
                    'description' => 'Cannot login to my account. Password reset not working.',
                    'status' => 'resolved',
                    'priority' => 'medium'
                ],
                [
                    'subject' => 'Property Listing Issue',
                    'description' => 'My property is not showing up in search results.',
                    'status' => 'in_progress',
                    'priority' => 'medium'
                ],
                [
                    'subject' => 'Photo Upload Problem',
                    'description' => 'Cannot upload photos for my property listing.',
                    'status' => 'open',
                    'priority' => 'low'
                ],
                [
                    'subject' => 'Booking Confirmation',
                    'description' => 'Did not receive booking confirmation email.',
                    'status' => 'resolved',
                    'priority' => 'low'
                ]
            ];

            foreach ($tickets as $ticketData) {
                SupportTicket::create([
                    'user_id' => $users->random()->id,
                    'subject' => $ticketData['subject'],
                    'description' => $ticketData['description'],
                    'status' => $ticketData['status'],
                    'priority' => $ticketData['priority'],
                    'assigned_to' => $subadmins->count() > 0 ? $subadmins->random()->id : null,
                    'resolved_at' => $ticketData['status'] === 'resolved' ? now()->subDays(rand(1, 7)) : null
                ]);
            }
        }
    }
}
