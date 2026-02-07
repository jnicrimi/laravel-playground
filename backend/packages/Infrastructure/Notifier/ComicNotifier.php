<?php

declare(strict_types=1);

namespace Packages\Infrastructure\Notifier;

use App\Jobs\ComicDestroyNotificationJob;
use App\Jobs\ComicStoreNotificationJob;
use App\Jobs\ComicUpdateNotificationJob;
use Packages\Domain\Comic\Comic;
use Packages\UseCase\Comic\ComicNotifierInterface;

class ComicNotifier implements ComicNotifierInterface
{
    public function notifyStore(Comic $comic): void
    {
        $comicAttributes = $comic->toArray();
        ComicStoreNotificationJob::dispatch($comicAttributes);
    }

    public function notifyUpdate(Comic $comic): void
    {
        $comicAttributes = $comic->toArray();
        ComicUpdateNotificationJob::dispatch($comicAttributes);
    }

    public function notifyDestroy(Comic $comic): void
    {
        $comicAttributes = $comic->toArray();
        ComicDestroyNotificationJob::dispatch($comicAttributes);
    }
}
