<p align="center">Документация</p>

<p align="center">
<a href="https://github.com/green-tmz/laravel-telegram-bot/releases"><img src="https://img.shields.io/badge/release-1.1.1-green" alt="Latest Version"></a>
<a href="https://github.com/green-tmz/laravel-telegram-bot/blob/master/LICENSE"><img src="https://img.shields.io/badge/license-MIT-blue.svg" alt="Software License"></a>
</p>

<h1 align="center">Laravel-telegram-bot</h1>
<h2 align="center">Laravel-telegram-bot пакет для Laravel 12.x</h2>

## Требования

- PHP >= 8.2
- Laravel 12.x

## Установка

Установить через composer, выполнив команду в консоле:

```bash
composer require green-tmz/laravel-telegram-bot
```

Публикация конфигов:

```bash
php artisan vendor:publish --provider="Green\TelegramBot\Providers\TelegramServiceProvider"
```

Откройте ваш `.env` измените строку `APP_URL` на `APP_URL=https://<ваш_домен>`
и добавьте в конец файла
```dotenv
TELEGRAM_BOT_TOKEN=<API_TOKEN_ВАШЕГО_БОТА>
TELEGRAM_WEBHOOK_URL=/telegram/webhook
```

Регистрация веб-хуков:

```bash
php artisan telegram:set-webhook
```

Публикация команд:

Для публикации команд Telegram выполните:

```bash
php artisan telegram:publish-commands
```

В `config/telegram.php` для команд поменять namespace на
`\App\Console\Commands\TelegramBot\<класс_обработки_команды>`.

Пример:
```php
'commands' => [
    'start' => \App\Console\Commands\TelegramBot\StartCommand::class,
    'set-webhook' => \Green\TelegramBot\Console\Commands\SetupTelegramWebhook::class,
],
````

## Базовое использование

Для работы с ботом добавьте фасад Telegram:

```php
use Green\TelegramBot\Facades\Telegram;
```

### Отправка сообщения:

```php
public function handle(array $update): void
{
    $chatId = $update['message']['chat']['id'];
    $name = $update['message']['from']['first_name'];

    Telegram::sendMessage($chatId, "Привет, $name! Добро пожаловать!");
}
```

### Использование клавиатуры:

- reply keyboard

```php
use Green\TelegramBot\Facades\Telegram;
use Green\TelegramBot\Services\Keyboard;

public function handle(array $update): void
{
    $chatId = $update['message']['chat']['id'];
    $name = $update['message']['from']['first_name'];

    $keyboard = Keyboard::make()
        ->setResizeKeyboard(true)
        ->setOneTimeKeyboard(true)
        ->setSelective(false)
        ->row([
            Keyboard::button('Обычная кнопка 1'),
            Keyboard::button('Обычная кнопка 2'),
        ])
        ->row([
            Keyboard::button('Отправить мой контакт')->requestContact(),
        ])
        ->row([
            Keyboard::button('Отправить мою локацию')->requestLocation(),
        ])
        ->row([
            Keyboard::button('Специальная кнопка')
                ->callbackData('action=special_action&user_id=123'),
        ]);

    Telegram::sendMessage($chatId, "Привет, $name! Добро пожаловать!", [
        'reply_markup' => $keyboard->toJson()
    ]);
}
```

## Лицензия

Лицензия MIT. Пожалуйста
прочитайте [Файл лицензии](https://github.com/green-tmz/laravel-telegram-bot/blob/master/LICENSE) для получения
дополнительной информации.
