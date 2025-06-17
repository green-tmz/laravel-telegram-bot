<?php

namespace Green\TelegramBot\Console\Commands;

use Illuminate\Console\Command;
use Green\TelegramBot\Facades\Telegram;

class SetupTelegramWebhook extends Command
{
    protected $signature = 'telegram:set-webhook';
    protected $description = 'Setup Telegram webhook URL';

    public function handle()
    {
        $url = route('telegram.webhook');
        $this->info("Setting webhook to: {$url}");

        if (Telegram::setWebhook($url)) {
            $this->info('Webhook set successfully!');
        } else {
            $this->error('Failed to set webhook');
        }
    }
}
