<?php

declare(strict_types=1);

namespace Tests\Unit\Packages\Infrastructure\Service\Notification;

use App\Notifications\SlackNotification;
use Illuminate\Support\Facades\Notification;
use Packages\Infrastructure\Service\Notification\SlackNotificationService;
use Tests\TestCase;

class SlackNotificationServiceTest extends TestCase
{
    private SlackNotificationService $service;

    public function setUp(): void
    {
        parent::setUp();
        $this->service = $this->app->make(SlackNotificationService::class);
    }

    public function testSend(): void
    {
        $expectedMessage = 'test';
        Notification::fake();
        Notification::assertNothingSent();
        $this->service->send($expectedMessage);
        Notification::assertSentToTimes(
            new SlackNotificationService,
            SlackNotification::class,
            1
        );
        Notification::assertSentTo(
            new SlackNotificationService,
            SlackNotification::class,
            function ($notification, $channels) use ($expectedMessage) {
                $reflectedNotification = new \ReflectionClass($notification);
                $messageProperty = $reflectedNotification->getProperty('message');
                $messageProperty->setAccessible(true);
                $actualMessage = $messageProperty->getValue($notification);
                $this->assertEquals($expectedMessage, $actualMessage);

                return true;
            }
        );
    }
}
