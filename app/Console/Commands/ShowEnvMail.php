<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class ShowEnvMail extends Command
{
    protected $signature = 'mail:show-config';
    protected $description = 'Show current mail configuration from .env file';

    public function handle()
    {
        $envPath = base_path('.env');

        if (!File::exists($envPath)) {
            $this->error('.env file not found!');
            return 1;
        }

        $envContent = File::get($envPath);
        $lines = explode("\n", $envContent);
        
        $this->info('Current mail configuration in .env:');
        $this->info('=====================================');
        
        $mailKeys = [
            'MAIL_MAILER',
            'MAIL_HOST', 
            'MAIL_PORT',
            'MAIL_USERNAME',
            'MAIL_PASSWORD',
            'MAIL_ENCRYPTION',
            'MAIL_FROM_ADDRESS',
            'MAIL_FROM_NAME'
        ];
        
        foreach ($lines as $line) {
            foreach ($mailKeys as $key) {
                if (strpos($line, $key . '=') === 0) {
                    $this->info($line);
                }
            }
        }
        
        $this->info('=====================================');
        $this->info('Current Laravel config values:');
        $this->info('MAIL_MAILER: ' . config('mail.default'));
        $this->info('MAIL_HOST: ' . config('mail.mailers.smtp.host'));
        $this->info('MAIL_PORT: ' . config('mail.mailers.smtp.port'));
        
        return 0;
    }
}
