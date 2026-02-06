<?php

declare(strict_types=1);

use Carbon\Carbon;
use Illuminate\Http\Response;
use Illuminate\Support\Arr;
use Illuminate\Testing\TestResponse;
use Packages\Domain\Comic\Comic;
use Packages\Domain\Comic\ComicId;
use Packages\Domain\Comic\ComicKey;
use Packages\Domain\Comic\ComicName;
use Packages\Domain\Comic\ComicStatus;
use Packages\Domain\Pagination;

/**
 * Comic エンティティのデフォルト属性配列を返す
 */
function defaultComicAttributes(): array
{
    return [
        'id' => 1,
        'key' => 'default-key',
        'name' => 'default_name',
        'status' => 'published',
        'created_at' => '2023-01-01 00:00:00',
        'updated_at' => '2023-12-31 23:59:59',
    ];
}

/**
 * 属性配列から Comic ドメインオブジェクトを生成する
 */
function createComic(array $attributes): Comic
{
    return new Comic(
        Arr::get($attributes, 'id') ? new ComicId(Arr::get($attributes, 'id')) : null,
        new ComicKey(Arr::get($attributes, 'key')),
        new ComicName(Arr::get($attributes, 'name')),
        ComicStatus::from(Arr::get($attributes, 'status')),
        Arr::get($attributes, 'created_at') ? Carbon::parse(Arr::get($attributes, 'created_at')) : null,
        Arr::get($attributes, 'updated_at') ? Carbon::parse(Arr::get($attributes, 'updated_at')) : null,
    );
}

/**
 * テスト用の Pagination オブジェクトを生成する
 */
function createPagination(): Pagination
{
    return new Pagination(
        perPage: 5,
        currentPage: 1,
        lastPage: 2,
        total: 10,
        firstItem: 1,
        lastItem: 5,
    );
}

/**
 * Comic API レスポンスを検証する
 */
function assertComicResponse(TestResponse $response, array $expected): void
{
    $response->assertStatus($expected['status']);
    if ($expected['status'] === Response::HTTP_OK) {
        $response->assertJsonStructure([
            'data' => [
                'comic' => [
                    'id',
                    'key',
                    'name',
                    'status' => [
                        'value',
                        'description',
                    ],
                ],
            ],
        ]);
    } else {
        $response->assertJsonStructure(['code', 'message']);
        $response->assertJson([
            'code' => $expected['code'],
            'message' => $expected['message'],
        ]);
    }
}
