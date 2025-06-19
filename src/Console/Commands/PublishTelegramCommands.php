<?php

namespace Green\TelegramBot\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

class PublishTelegramCommands extends Command
{
    protected $signature = 'telegram:publish-commands {--force : Overwrite existing files}';

    protected $description = 'Publish Telegram commands with proper namespace';

    public function handle(Filesystem $filesystem)
    {
        $from = __DIR__.'/../../../src/Console/Commands';
        $to = app_path('Console/Commands/TelegramBot');

        if (! $filesystem->isDirectory($from)) {
            $this->error("Source directory not found: {$from}");
            return 1;
        }

        if (! $filesystem->isDirectory($to)) {
            $filesystem->makeDirectory($to, 0755, true);
        }

        $files = $filesystem->allFiles($from);

        foreach ($files as $file) {
            $target = $to.'/'.$file->getRelativePathname();

            // Проверяем, нужно ли перезаписывать файл
            if ($file->isFile() && (!$filesystem->exists($target) || $this->option('force'))) {
                $content = $filesystem->get($file->getPathname());

                // Заменяем namespace
                $content = str_replace(
                    'namespace Green\\TelegramBot\\Console\\Commands;',
                    'namespace App\\Console\\Commands\\TelegramBot;',
                    $content
                );

                // Заменяем ссылки на классы в use
                $content = preg_replace(
                    '/use Green\\\\TelegramBot\\\\Console\\\\Commands\\\\/',
                    'use App\\Console\\Commands\\TelegramBot\\',
                    $content
                );

                $filesystem->put($target, $content);
                $this->info("Published: {$target}");
            }
        }

        $this->info('Telegram commands published successfully with proper namespace!');
        return 0;
    }
}
