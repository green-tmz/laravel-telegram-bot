<?php

declare(strict_types=1);

namespace Green\TelegramBot\Http\Controllers;

use Green\TelegramBot\Facades\Telegram;
use Illuminate\Http\Request;

class WebhookController extends Controller
{
    public function __invoke(Request $request)
    {
        Telegram::handleUpdate($request->all());
        return response()->json(['status' => 'success']);
    }
}
