<?php

return [
    'token' => env('TELEGRAM_BOT_TOKEN'),
    'webhook_url' => env('TELEGRAM_WEBHOOK_URL', '/telegram/webhook'),
    'commands' => [
        'start' => \Green\TelegramBot\Console\Commands\StartCommand::class,
        'set-webhook' => \Green\TelegramBot\Console\Commands\SetupTelegramWebhook::class,
    ],
];
