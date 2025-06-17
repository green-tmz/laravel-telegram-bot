<?php

declare(strict_types=1);

namespace Green\TelegramBot\Providers;

use Green\TelegramBot\Services\TelegramService;
use Illuminate\Support\ServiceProvider;

class TelegramServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/telegram.php', 'telegram');

        $this->app->singleton('telegram.bot', function ($app) {
            return new TelegramService(
                config('telegram.token')
            );
        });
    }

    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/telegram.php' => config_path('telegram.php'),
        ], 'telegram-config');

        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
    }
}
