<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class FixMailConfig extends Command
{
    protected $signature = 'mail:fix-config {--mode=development}';
    protected $description = 'Fix mail configuration for development or production';

    public function handle()
    {
        $mode = $this->option('mode');
        $envPath = base_path('.env');

        if (!File::exists($envPath)) {
            $this->error('.env file not found!');
            return 1;
        }

        $envContent = File::get($envPath);

        if ($mode === 'development') {
            $this->info('Setting up mail configuration for development...');
            
            // Replace mail configuration with log driver
            $envContent = $this->updateEnvValue($envContent, 'MAIL_MAILER', 'log');
            $envContent = $this->updateEnvValue($envContent, 'MAIL_HOST', 'localhost');
            $envContent = $this->updateEnvValue($envContent, 'MAIL_PORT', '2525');
            $envContent = $this->updateEnvValue($envContent, 'MAIL_USERNAME', 'null');
            $envContent = $this->updateEnvValue($envContent, 'MAIL_PASSWORD', 'null');
            $envContent = $this->updateEnvValue($envContent, 'MAIL_ENCRYPTION', 'null');
            $envContent = $this->updateEnvValue($envContent, 'MAIL_FROM_ADDRESS', 'noreply@roomyatra.local');
            $envContent = $this->updateEnvValue($envContent, 'MAIL_FROM_NAME', 'RoomYatra');
            
        } else {
            $this->info('Setting up mail configuration for production...');
            $this->info('Please configure these values manually in your .env file:');
            $this->info('MAIL_MAILER=smtp');
            $this->info('MAIL_HOST=your-smtp-host');
            $this->info('MAIL_PORT=587');
            $this->info('MAIL_USERNAME=your-email@domain.com');
            $this->info('MAIL_PASSWORD=your-password');
            $this->info('MAIL_ENCRYPTION=tls');
            $this->info('MAIL_FROM_ADDRESS=noreply@yourdomain.com');
            $this->info('MAIL_FROM_NAME=RoomYatra');
        }

        File::put($envPath, $envContent);
        
        $this->info('✅ Mail configuration updated successfully!');
        $this->info('Run: php artisan config:clear');
        $this->info('Then test with: php artisan test:email');

        return 0;
    }

    private function updateEnvValue($envContent, $key, $value)
    {
        $pattern = "/^{$key}=.*/m";
        $replacement = "{$key}={$value}";
        
        if (preg_match($pattern, $envContent)) {
            return preg_replace($pattern, $replacement, $envContent);
        } else {
            return $envContent . "\n{$replacement}";
        }
    }
}
