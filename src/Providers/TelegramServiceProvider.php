<?php

declare(strict_types=1);

namespace Green\TelegramBot\Providers;

use Green\TelegramBot\Console\Commands\StartCommand;
use Green\TelegramBot\Console\Commands\SetupTelegramWebhook;
use Green\TelegramBot\Services\TelegramService;
use Illuminate\Support\ServiceProvider;

class TelegramServiceProvider extends ServiceProvider
{
    protected array $commands = [
        SetupTelegramWebhook::class,
        StartCommand::class,
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
            __DIR__.'/../Console/Commands' => app_path('Console/Commands/vendor/TelegramBot'),
        ], 'telegram-commands');

        if ($this->app->runningInConsole()) {
            $this->registerCommands($this->commands);
        }

        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
    }

    protected function registerCommands(array $commands): void
    {
        $registeredCommands = [];

        foreach ($commands as $command) {
            $appNamespace = $this->getAppNamespace() . $command;
            $packageNamespace = $this->getPackageNamespace() . $command;

            if (class_exists($appNamespace)) {
                $registeredCommands[] = $appNamespace;
            } else {
                $registeredCommands[] = $packageNamespace;
            }
        }

        $this->commands($registeredCommands);
    }

    protected function getAppNamespace(): string
    {
        return 'App\\Console\\Commands\\Vendor\\TelegramBot\\';
    }

    protected function getPackageNamespace(): string
    {
        return '';
    }
}
