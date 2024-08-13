<?php

declare(strict_types=1);

namespace App\Providers;

use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\ServiceProvider;
use Packages\Application\Comic\ComicDestroyInteractor;
use Packages\Application\Comic\ComicIndexInteractor;
use Packages\Application\Comic\ComicShowInteractor;
use Packages\Application\Comic\ComicStoreInteractor;
use Packages\Application\Comic\ComicUpdateInteractor;
use Packages\Domain\Comic\ComicRepositoryInterface;
use Packages\Infrastructure\Notifier\ComicNotifier;
use Packages\Infrastructure\Repository\Comic\ComicRepository;
use Packages\Infrastructure\Service\Notification\LogNotificationService;
use Packages\Infrastructure\Service\Notification\NotificationServiceInterface;
use Packages\Infrastructure\Service\Notification\SlackNotificationService;
use Packages\UseCase\Comic\Destroy\ComicDestroyUseCaseInterface;
use Packages\UseCase\Comic\Index\ComicIndexUseCaseInterface;
use Packages\UseCase\Comic\Show\ComicShowUseCaseInterface;
use Packages\UseCase\Comic\Store\ComicStoreUseCaseInterface;
use Packages\UseCase\Comic\Update\ComicUpdateUseCaseInterface;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @throws Exception
     */
    public function register(): void
    {

        // Repository
        $this->app->bind(ComicRepositoryInterface::class, ComicRepository::class);
        // UseCase
        $this->app->bind(ComicDestroyUseCaseInterface::class, ComicDestroyInteractor::class);
        $this->app->bind(ComicIndexUseCaseInterface::class, ComicIndexInteractor::class);
        $this->app->bind(ComicShowUseCaseInterface::class, ComicShowInteractor::class);
        $this->app->bind(ComicStoreUseCaseInterface::class, ComicStoreInteractor::class);
        $this->app->bind(ComicUpdateUseCaseInterface::class, ComicUpdateInteractor::class);
        // Notifier
        $this->app->bind(ComicNotifier::class, ComicNotifier::class);
        // NotificationService
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
        JsonResource::withoutWrapping();
    }
}
