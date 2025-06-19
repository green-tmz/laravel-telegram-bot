# Laravel-telegram-bot

## Установка
- `composer require green-tmz/laravel-telegram-bot`
- `php artisan vendor:publish --tag=telegram-config`
- `php artisan vendor:publish --provider="Green\TelegramBot\Providers\TelegramServiceProvider" --tag="telegram-config"`

## Настройка

- в `.env ` указать `APP_URL=https://<ваш_домен>`
- Регистрация веб-хуков: `php artisan telegram:set-webhook`

## Публикация команд

Для публикации команд Telegram выполните:

`php artisan telegram:publish-commands`

В `config/telegram.php` для команд поменять namespace на 
`\App\Console\Commands\TelegramBot\<класс_обработки_команды>`. 

Пример:
```bash
'commands' => [
    'start' => \App\Console\Commands\TelegramBot\StartCommand::class,
    'set-webhook' => \Green\TelegramBot\Console\Commands\SetupTelegramWebhook::class,
],
