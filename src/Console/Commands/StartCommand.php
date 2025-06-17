<?php

declare(strict_types=1);

namespace Green\TelegramBot\Console\Commands;

use Green\TelegramBot\Facades\Telegram;

class StartCommand
{
    public function handle(array $update)
    {
        $chatId = $update['message']['chat']['id'];
        $name = $update['message']['from']['first_name'];

        Telegram::sendMessage($chatId, "Привет, $name! Добро пожаловать!");
    }
}
