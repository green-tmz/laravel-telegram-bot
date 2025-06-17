<?php

declare(strict_types=1);

namespace Green\TelegramBot\Services;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class TelegramService
{
    protected Client $client;
    protected string $token;
    protected string $apiUrl = 'https://api.telegram.org/bot';

    public function __construct(string $token)
    {
        $this->token = $token;
        $this->client = new Client([
            'base_uri' => $this->apiUrl . $this->token . '/',
            'timeout'  => 5.0,
        ]);
    }

    public function sendMessage(int $chatId, string $text, array $params = [])
    {
        $data = array_merge([
            'chat_id' => $chatId,
            'text' => $text,
            'parse_mode' => 'HTML'
        ], $params);

        try {
            $response = $this->client->post('sendMessage', ['json' => $data]);
            $responseBody = $response->getBody()->getContents();
            return json_decode($responseBody, true);
        } catch (\Exception $e) {
            Log::error('Telegram API Error: ' . $e->getMessage());
            return false;
        }
    }

    public function setWebhook(string $url): bool
    {
        try {
            $response = $this->client->post('setWebhook', [
                'json' => ['url' => $url]
            ]);
            $responseBody = $response->getBody()->getContents();
            return json_decode($responseBody)->ok ?? false;
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
