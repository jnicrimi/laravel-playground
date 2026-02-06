<?php

declare(strict_types=1);

use App\Jobs\ComicDestroyNotificationJob;
use App\Jobs\ComicStoreNotificationJob;
use App\Jobs\ComicUpdateNotificationJob;
use Illuminate\Support\Facades\Queue;
use Packages\Infrastructure\Notifier\ComicNotifier;

beforeEach(function () {
    Queue::fake();
    $this->notifier = $this->app->make(ComicNotifier::class);
    $this->comic = createComic(defaultComicAttributes());
});

test('notify store', function () {
    $this->notifier->notifyStore($this->comic);
    Queue::assertPushed(ComicStoreNotificationJob::class, function ($job) {
        return $job->comic['id'] === 1;
    });
});

test('notify update', function () {
    $this->notifier->notifyUpdate($this->comic);
    Queue::assertPushed(ComicUpdateNotificationJob::class, function ($job) {
        return $job->comic['id'] === 1;
    });
});

test('notify destroy', function () {
    $this->notifier->notifyDestroy($this->comic);
    Queue::assertPushed(ComicDestroyNotificationJob::class, function ($job) {
        return $job->comic['id'] === 1;
    });
});
