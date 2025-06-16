<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use App\Notifications\BookingRequestNotification;
use App\Models\Booking;

class TestEmail extends Command
{
    protected $signature = 'test:email {--user=1}';
    protected $description = 'Test email configuration';

    public function handle()
    {
        $userId = $this->option('user');
        $user = User::find($userId);

        if (!$user) {
            $this->error("User with ID {$userId} not found");
            return 1;
        }

        try {
            // Test basic email
            Mail::raw('This is a test email from RoomYatra', function ($message) use ($user) {
                $message->to($user->email)
                       ->subject('Test Email from RoomYatra');
            });

            $this->info('✅ Test email sent successfully!');
            $this->info("Email sent to: {$user->email}");
            
            // Show current mail configuration
            $this->info("\nCurrent mail configuration:");
            $this->info("Mailer: " . config('mail.default'));
            $this->info("Host: " . config('mail.mailers.smtp.host'));
            $this->info("Port: " . config('mail.mailers.smtp.port'));
            
        } catch (\Exception $e) {
            $this->error('❌ Failed to send test email');
            $this->error('Error: ' . $e->getMessage());
            
            $this->info("\nTroubleshooting suggestions:");
            $this->info("1. Check your .env file mail configuration");
            $this->info("2. For development, use MAIL_MAILER=log");
            $this->info("3. For production, configure SMTP settings");
            $this->info("4. Run: php artisan config:clear");
            
            return 1;
        }

        return 0;
    }
}
