<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    // @phpstan-ignore-next-line
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

Artisan::command('logs:clear', function () {
    $files = glob(storage_path('logs/*.log'));
    foreach ($files as $file) {
        if (is_file($file)) {
            unlink($file);
        }
    }
    // @phpstan-ignore-next-line
    $this->comment('Logs have been cleared!');
})->describe('Clear log files');
