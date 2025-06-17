<?php

declare(strict_types=1);

namespace Green\TelegramBot\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static mixed sendMessage(int $chatId, string $text, array $params = [])
 * @method static mixed setWebhook(string $url)
 * @method static mixed handleUpdate(array $update)
 */
class Telegram extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'telegram.bot';
    }
}
