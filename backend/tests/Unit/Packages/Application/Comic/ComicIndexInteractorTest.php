<?php

declare(strict_types=1);

use Illuminate\Support\Arr;
use Packages\Application\Comic\ComicIndexInteractor;
use Packages\UseCase\Comic\Index\ComicIndexRequest;
use Packages\UseCase\Comic\Index\ComicIndexResponse;

beforeEach(function () {
    $this->interactor = $this->app->make(ComicIndexInteractor::class);
});

describe('handle', function () {
    test('success', function (array $params) {
        $key = Arr::get($params, 'key');
        $name = Arr::get($params, 'name');
        $status = Arr::get($params, 'status');
        $request = new ComicIndexRequest(
            key: $key,
            name: $name,
            status: $status
        );
        $response = $this->interactor->handle($request);
        expect($response)->toBeInstanceOf(ComicIndexResponse::class);
        $comics = Arr::get($response->build(), 'comics', []);
        expect($comics)->not->toBeEmpty();
        foreach ($comics as $comic) {
            if (isset($key)) {
                expect(Arr::get($comic, 'key'))->toBe($key);
            }
            if (isset($name)) {
                expect(Arr::get($comic, 'name'))->toContain($name);
            }
            if (isset($status)) {
                expect($status)->toContain(Arr::get($comic, 'status.value'));
            }
        }
    })->with('search params');
});

dataset('search params', function () {
    return [
        '指定なし' => [
            'params' => [],
        ],
        'key を指定' => [
            'params' => [
                'key' => 'default-key-1',
            ],
        ],
        'name を指定' => [
            'params' => [
                'name' => 'default',
            ],
        ],
        'status を指定' => [
            'params' => [
                'status' => ['published'],
            ],
        ],
        '全てのパラメータを指定' => [
            'params' => [
                'key' => 'default-key-2',
                'name' => 'default',
                'status' => ['draft'],
            ],
        ],
    ];
});
