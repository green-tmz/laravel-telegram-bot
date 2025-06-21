<?php

declare(strict_types=1);

namespace Green\TelegramBot\Providers;

use Green\TelegramBot\Console\Commands\PublishTelegramCommands;
use Green\TelegramBot\Console\Commands\StartCommand;
use Green\TelegramBot\Console\Commands\SetupTelegramWebhook;
use Green\TelegramBot\Services\TelegramService;
use Illuminate\Support\ServiceProvider;

class TelegramServiceProvider extends ServiceProvider
{
    protected array $commands = [
        SetupTelegramWebhook::class,
        StartCommand::class,
        PublishTelegramCommands::class, // Добавлено
    ];

    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/telegram.php', 'telegram');

        $this->app->singleton('telegram.bot', function ($app) {
            return new TelegramService(
                config('telegram.token')
            );
        });
    }

    public function boot(): void
    {
        $this->publishes([
            __DIR__.'/../config/telegram.php' => config_path('telegram.php'),
        ], 'telegram-config');

        $this->publishes([
            __DIR__.'/../Console/Commands/' => app_path('Console/Commands/TelegramBot'),
        ], 'telegram-commands');

        if ($this->app->runningInConsole()) {
            $this->commands($this->commands);
        }

        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
    }
}
