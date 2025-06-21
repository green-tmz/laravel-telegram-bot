<?php

declare(strict_types=1);

namespace Green\TelegramBot\Services;

class KeyboardButton
{
    protected string $text;
    protected array $options = [];

    public function __construct(string $text)
    {
        $this->text = $text;
    }

    public static function make(string $text): self
    {
        return new self($text);
    }

    public function requestContact(): self
    {
        $this->options['request_contact'] = true;
        return $this;
    }

    public function requestLocation(): self
    {
        $this->options['request_location'] = true;
        return $this;
    }

    public function withData(string $key, $value): self
    {
        $this->options[$key] = $value;
        return $this;
    }

    public function callbackData(string $data): self
    {
        $this->options['callback_data'] = $data;
        return $this;
    }

    public function toArray(): array
    {
        return array_merge(['text' => $this->text], $this->options);
    }
}
