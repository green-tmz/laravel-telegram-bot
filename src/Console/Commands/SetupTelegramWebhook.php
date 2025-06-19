<?php

declare(strict_types=1);

namespace Green\TelegramBot\Console\Commands;

use Illuminate\Console\Command;

class SetupTelegramWebhook extends Command
{
    protected $signature = 'telegram:set-webhook {url?}';
    protected $description = 'Set Telegram bot webhook URL';

    public function handle(): void
    {
        $telegram = app('telegram.bot');

        $url = $this->argument('url') ?? env("APP_URL") .config('telegram.webhook_url');

        if (empty($url)) {
            $this->error('Webhook URL is not configured');
            return;
        }

        $response = $telegram->setWebhook($url);

        $this->info('Webhook set to: ' . $url);
        $this->info('Response: ' . json_encode($response, JSON_PRETTY_PRINT));
    }
}
