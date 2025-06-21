<?php

declare(strict_types=1);

namespace Green\TelegramBot\Services;

class Keyboard
{
    protected array $keyboard = [];
    protected bool $resizeKeyboard = false;
    protected bool $oneTimeKeyboard = false;
    protected bool $selective = false;

    public static function make(): self
    {
        return new self();
    }

    public static function button(string $text): KeyboardButton
    {
        return KeyboardButton::make($text);
    }

    public function setResizeKeyboard(bool $value): self
    {
        $this->resizeKeyboard = $value;
        return $this;
    }

    public function setOneTimeKeyboard(bool $value): self
    {
        $this->oneTimeKeyboard = $value;
        return $this;
    }

    public function setSelective(bool $value): self
    {
        $this->selective = $value;
        return $this;
    }

    public function row(array $buttons): self
    {
        $row = [];
        foreach ($buttons as $button) {
            if ($button instanceof KeyboardButton) {
                $row[] = $button->toArray();
            } else {
                $row[] = ['text' => $button];
            }
        }
        $this->keyboard[] = $row;
        return $this;
    }

    public function toArray(): array
    {
        return [
            'keyboard' => $this->keyboard,
            'resize_keyboard' => $this->resizeKeyboard,
            'one_time_keyboard' => $this->oneTimeKeyboard,
            'selective' => $this->selective,
        ];
    }

    public function toJson(): string
    {
        return json_encode($this->toArray());
    }
}
