<?php

declare(strict_types=1);

namespace Tests\Unit\Packages\Infrastructure\Service\Notification;

use Illuminate\Support\Facades\Log;
use Packages\Infrastructure\Service\Notification\LogNotificationService;
use Tests\TestCase;

class LogNotificationServiceTest extends TestCase
{
    private LogNotificationService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = $this->app->make(LogNotificationService::class);
    }

    public function test_send(): void
    {
        $spy = Log::spy();
        $expectedMessage = 'test';
        $this->service->send($expectedMessage);
        $spy->shouldHaveReceived('info', [$expectedMessage]);
    }
}
