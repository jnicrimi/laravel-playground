<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Queue;
use Packages\Application\Comic\ComicUpdateInteractor;
use Packages\Domain\Comic\ComicStatus;
use Packages\UseCase\Comic\Exception\ComicAlreadyExistsException;
use Packages\UseCase\Comic\Exception\ComicNotFoundException;
use Packages\UseCase\Comic\Update\ComicUpdateRequest;
use Packages\UseCase\Comic\Update\ComicUpdateResponse;

beforeEach(function () {
    $this->interactor = $this->app->make(ComicUpdateInteractor::class);
});

describe('handle', function () {
    test('success', function () {
        Queue::fake();
        $request = new ComicUpdateRequest(
            id: 1,
            key: 'test-key-1',
            name: 'test_name_1',
            status: ComicStatus::CLOSED->value
        );
        $response = $this->interactor->handle($request);
        expect($response)->toBeInstanceOf(ComicUpdateResponse::class);
        expect($response->build())->toBe([
            'comic' => [
                'id' => 1,
                'key' => 'test-key-1',
                'name' => 'test_name_1',
                'status' => [
                    'value' => 'closed',
                    'description' => '非公開',
                ],
            ],
        ]);
    });

    test('failure by not found', function () {
        expect(fn () => $this->interactor->handle(
            new ComicUpdateRequest(
                id: PHP_INT_MAX,
                key: 'test-key-1',
                name: 'test_name_1',
                status: ComicStatus::CLOSED->value
            )
        ))->toThrow(ComicNotFoundException::class);
    });

    test('failure by duplicate key', function () {
        expect(fn () => $this->interactor->handle(
            new ComicUpdateRequest(
                id: 1,
                key: 'default-key-2',
                name: 'test_name_1',
                status: ComicStatus::CLOSED->value
            )
        ))->toThrow(ComicAlreadyExistsException::class);
    });
});
