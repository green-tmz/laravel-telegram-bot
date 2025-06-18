<?php

use Illuminate\Support\Facades\Route;
use Green\TelegramBot\Http\Controllers\WebhookController;

Route::post(config('telegram.webhook_url'), WebhookController::class)
    ->name('telegram.webhook');
