<?php

declare(strict_types=1);

namespace Packages\Infrastructure\Service\Notification;

interface NotificationServiceInterface
{
    public function send(string $message): void;
}
