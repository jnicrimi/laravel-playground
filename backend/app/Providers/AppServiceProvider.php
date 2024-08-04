<?php

namespace App\Providers;

use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;
use Packages\Infrastructure\Service\Notification\LogNotificationService;
use Packages\Infrastructure\Service\Notification\NotificationServiceInterface;
use Packages\Infrastructure\Service\Notification\SlackNotificationService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @throws Exception
     */
    public function register(): void
    {
        $notificationService = config('notification.service');
        if ($notificationService === 'slack') {
            $this->app->bind(NotificationServiceInterface::class, SlackNotificationService::class);
        } elseif ($notificationService === 'log') {
            $this->app->bind(NotificationServiceInterface::class, LogNotificationService::class);
        } else {
            throw new Exception('Invalid notification service');
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Model::shouldBeStrict(! $this->app->isProduction());
    }
}
