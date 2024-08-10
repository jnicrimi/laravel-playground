<?php

declare(strict_types=1);

namespace Tests\Unit\Packages\Application\Comic;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Arr;
use Packages\Application\Comic\ComicIndexInteractor;
use Packages\UseCase\Comic\Index\ComicIndexRequest;
use Packages\UseCase\Comic\Index\ComicIndexResponse;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class ComicIndexInteractorTest extends TestCase
{
    use RefreshDatabase;

    private ComicIndexInteractor $interactor;

    public function setUp(): void
    {
        parent::setUp();
        $this->interactor = $this->app->make(ComicIndexInteractor::class);
    }

    #[DataProvider('provideHandleSuccess')]
    public function testHandleSuccess(array $params): void
    {
        $key = Arr::get($params, 'key');
        $name = Arr::get($params, 'name');
        $status = Arr::get($params, 'status');
        $request = new ComicIndexRequest(
            key: $key,
            name: $name,
            status: $status
        );
        $response = $this->interactor->handle($request);
        $this->assertInstanceOf(ComicIndexResponse::class, $response);
        $comics = Arr::get($response->build(), 'comics', []);
        if (count($comics) === 0) {
            $this->fail('comics is empty.');
        }
        foreach ($comics as $comic) {
            if (isset($key)) {
                $this->assertTrue(Arr::get($comic, 'key') === $key);
            }
            if (isset($name)) {
                $this->assertTrue(strpos(Arr::get($comic, 'name'), $name) !== false);
            }
            if (isset($status)) {
                $this->assertTrue(in_array(Arr::get($comic, 'status.value'), $status));
            }
        }
    }

    public static function provideHandleSuccess(): array
    {
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
    }
}
