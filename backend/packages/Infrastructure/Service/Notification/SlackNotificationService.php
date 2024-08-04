<?php

declare(strict_types=1);

namespace Packages\Infrastructure\Service\Notification;

use App\Notifications\SlackNotification;
use Illuminate\Notifications\Notifiable;

class SlackNotificationService implements NotificationServiceInterface
{
    use Notifiable;

    public function send(string $message): void
    {
        $this->notify(new SlackNotification($message));
    }

    protected function routeNotificationForSlack(): string
    {
        return config('slack.webhook_url');
    }

    public function getKey(): void {}
}
