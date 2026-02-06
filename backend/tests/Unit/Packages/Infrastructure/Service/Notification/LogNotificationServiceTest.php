<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Log;
use Packages\Infrastructure\Service\Notification\LogNotificationService;

beforeEach(function () {
    $this->service = $this->app->make(LogNotificationService::class);
});

test('send', function () {
    $spy = Log::spy();
    $expectedMessage = 'test';
    $this->service->send($expectedMessage);
    $spy->shouldHaveReceived('info', [$expectedMessage]);
});
