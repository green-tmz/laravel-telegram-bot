<?php

return [
    'token' => env('TELEGRAM_BOT_TOKEN'),
    'webhook_url' => env('TELEGRAM_WEBHOOK_URL', '/telegram/webhook'),
    'commands' => [
        'start' => \App\Console\Commands\Telegram\StartCommand::class,
        'set-webhook' => \Green\TelegramBot\Console\Commands\SetupTelegramWebhook::class,
    ],
];
