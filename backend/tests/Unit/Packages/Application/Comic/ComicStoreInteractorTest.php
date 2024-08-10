<?php

declare(strict_types=1);

namespace Tests\Unit\Packages\Application\Comic;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Queue;
use Packages\Application\Comic\ComicStoreInteractor;
use Packages\Domain\Comic\ComicStatus;
use Packages\UseCase\Comic\Exception\ComicAlreadyExistsException;
use Packages\UseCase\Comic\Store\ComicStoreRequest;
use Packages\UseCase\Comic\Store\ComicStoreResponse;
use Tests\TestCase;

class ComicStoreInteractorTest extends TestCase
{
    use RefreshDatabase;

    private ComicStoreInteractor $interactor;

    public function setUp(): void
    {
        parent::setUp();
        $this->interactor = $this->app->make(ComicStoreInteractor::class);
    }

    public function testHandleSuccess(): void
    {
        Queue::fake();
        $request = new ComicStoreRequest(
            key: 'test-key-1',
            name: 'test_name_1',
            status: ComicStatus::CLOSED->value
        );
        $response = $this->interactor->handle($request);
        $this->assertInstanceOf(ComicStoreResponse::class, $response);
        $expected = [
            'comic' => [
                'id' => $response->build()['comic']['id'],
                'key' => 'test-key-1',
                'name' => 'test_name_1',
                'status' => [
                    'value' => 'closed',
                    'description' => '非公開',
                ],
            ],
        ];
        $actual = $response->build();
        $this->assertSame($expected, $actual);
    }

    public function testHandleFailureByDuplicateKey(): void
    {
        $this->expectException(ComicAlreadyExistsException::class);
        $request = new ComicStoreRequest(
            key: 'default-key-1',
            name: 'test_name_1',
            status: ComicStatus::CLOSED->value
        );
        $this->interactor->handle($request);
    }
}
