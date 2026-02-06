<?php

declare(strict_types=1);

use App\Notifications\SlackNotification;
use Illuminate\Support\Facades\Notification;
use Packages\Infrastructure\Service\Notification\SlackNotificationService;

beforeEach(function () {
    $this->service = $this->app->make(SlackNotificationService::class);
});

test('send', function () {
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
            $reflectedNotification = new ReflectionClass($notification);
            $messageProperty = $reflectedNotification->getProperty('message');
            $messageProperty->setAccessible(true);
            $actualMessage = $messageProperty->getValue($notification);
            expect($actualMessage)->toEqual($expectedMessage);

            return true;
        }
    );
});
