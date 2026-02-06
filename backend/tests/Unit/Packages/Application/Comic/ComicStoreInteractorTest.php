<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Queue;
use Packages\Application\Comic\ComicStoreInteractor;
use Packages\Domain\Comic\ComicStatus;
use Packages\UseCase\Comic\Exception\ComicAlreadyExistsException;
use Packages\UseCase\Comic\Store\ComicStoreRequest;
use Packages\UseCase\Comic\Store\ComicStoreResponse;

beforeEach(function () {
    $this->interactor = $this->app->make(ComicStoreInteractor::class);
});

describe('handle', function () {
    test('success', function () {
        Queue::fake();
        $request = new ComicStoreRequest(
            key: 'test-key-1',
            name: 'test_name_1',
            status: ComicStatus::CLOSED->value
        );
        $response = $this->interactor->handle($request);
        expect($response)->toBeInstanceOf(ComicStoreResponse::class);
        expect($response->build())->toBe([
            'comic' => [
                'id' => $response->build()['comic']['id'],
                'key' => 'test-key-1',
                'name' => 'test_name_1',
                'status' => [
                    'value' => 'closed',
                    'description' => '非公開',
                ],
            ],
        ]);
    });

    test('failure by duplicate key', function () {
        expect(fn () => $this->interactor->handle(
            new ComicStoreRequest(
                key: 'default-key-1',
                name: 'test_name_1',
                status: ComicStatus::CLOSED->value
            )
        ))->toThrow(ComicAlreadyExistsException::class);
    });
});
