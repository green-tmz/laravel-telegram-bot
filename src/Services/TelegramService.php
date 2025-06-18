<?php

declare(strict_types=1);

namespace Green\TelegramBot\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class TelegramService
{
    protected string $token;
    protected string $apiUrl = "https://api.telegram.org/bot" ;
    protected string $base_uri;

    public function __construct(string $token)
    {
        $this->token = $token;
        $this->base_uri = $this->apiUrl . $this->token;
    }

    public function sendMessage(int $chatId, string $text, array $params = [])
    {
        $data = array_merge([
            'chat_id' => $chatId,
            'text' => $text,
            'parse_mode' => 'HTML'
        ], $params);

        try {
            $response = Http::post("{$this->base_uri}/sendMessage", ['json' => $data]);
            $responseBody = $response->getBody()->getContents();
            return json_decode($responseBody, true);
        } catch (\Exception $e) {
            Log::error('Telegram API Error: ' . $e->getMessage());
            return false;
        }
    }

    public function setWebhook(string $url)
    {
        try {
            $response = Http::get("{$this->base_uri}/setWebhook", [
                'url' => $url
            ]);
            $responseBody = $response->getBody()->getContents();
            return json_decode($responseBody, true);
        } catch (\Exception $e) {
            Log::error('Webhook Error: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * @throws \Exception
     */
    public function handleUpdate(array $update): void
    {
        $message = $update['message'] ?? $update['callback_query']['message'] ?? null;

        if (!$message) return;

        $text = $message['text'] ?? '';
        $chatId = $message['chat']['id'];

        // Обработка команд
        if (str_starts_with($text, '/')) {
            $command = strtolower(explode(' ', $text)[0]);
            $command = str_replace('/', '', $command);

            if ($handler = config("telegram.commands.$command")) {
                app($handler)->handle($update);
                return;
            }
        }

        // Дефолтный обработчик
        $this->sendMessage($chatId, "Команда не распознана");
    }
}
