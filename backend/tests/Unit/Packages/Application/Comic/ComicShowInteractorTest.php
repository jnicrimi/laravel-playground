<?php

declare(strict_types=1);

use Packages\Application\Comic\ComicShowInteractor;
use Packages\UseCase\Comic\Exception\ComicNotFoundException;
use Packages\UseCase\Comic\Show\ComicShowRequest;
use Packages\UseCase\Comic\Show\ComicShowResponse;

beforeEach(function () {
    $this->interactor = $this->app->make(ComicShowInteractor::class);
});

describe('handle', function () {
    test('success', function () {
        $request = new ComicShowRequest(id: 1);
        $response = $this->interactor->handle($request);
        expect($response)->toBeInstanceOf(ComicShowResponse::class);
        expect($response->build())->toBe([
            'comic' => [
                'id' => 1,
                'key' => 'default-key-1',
                'name' => 'default_name_1',
                'status' => [
                    'value' => 'published',
                    'description' => '公開',
                ],
            ],
        ]);
    });

    test('failure by not found', function () {
        expect(fn () => $this->interactor->handle(
            new ComicShowRequest(id: PHP_INT_MAX)
        ))->toThrow(ComicNotFoundException::class);
    });
});
