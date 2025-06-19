<?php

declare(strict_types=1);

namespace Green\TelegramBot\Console\Commands;

use Green\TelegramBot\Facades\Telegram;
use Illuminate\Console\Command;

class StartCommand extends Command
{
    protected $signature = 'telegram:start';
    protected $description = 'Send start command';

    public function handle(array $update): void
    {
        $chatId = $update['message']['chat']['id'];
        $name = $update['message']['from']['first_name'];

        Telegram::sendMessage($chatId, "Привет, $name! Добро пожаловать!");
    }
}
