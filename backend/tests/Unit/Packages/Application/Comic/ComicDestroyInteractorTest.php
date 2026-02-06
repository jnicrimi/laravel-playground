<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Queue;
use Packages\Application\Comic\ComicDestroyInteractor;
use Packages\UseCase\Comic\Destroy\ComicDestroyRequest;
use Packages\UseCase\Comic\Destroy\ComicDestroyResponse;
use Packages\UseCase\Comic\Exception\ComicCannotBeDeletedException;
use Packages\UseCase\Comic\Exception\ComicNotFoundException;

beforeEach(function () {
    $this->interactor = $this->app->make(ComicDestroyInteractor::class);
});

describe('handle', function () {
    test('success', function () {
        Queue::fake();
        $request = new ComicDestroyRequest(id: 3);
        $response = $this->interactor->handle($request);
        expect($response)->toBeInstanceOf(ComicDestroyResponse::class);
        expect($response->build())->toBe([
            'comic' => [
                'id' => 3,
                'key' => 'default-key-3',
                'name' => 'default_name_3',
                'status' => [
                    'value' => 'closed',
                    'description' => '非公開',
                ],
            ],
        ]);
    });

    test('failure by not found', function () {
        expect(fn () => $this->interactor->handle(
            new ComicDestroyRequest(id: PHP_INT_MAX)
        ))->toThrow(ComicNotFoundException::class);
    });

    test('failure by not closed status', function () {
        expect(fn () => $this->interactor->handle(
            new ComicDestroyRequest(id: 1)
        ))->toThrow(ComicCannotBeDeletedException::class);
    });
});
