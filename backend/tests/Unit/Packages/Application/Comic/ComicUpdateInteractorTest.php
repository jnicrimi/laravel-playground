<?php

declare(strict_types=1);

namespace Tests\Unit\Packages\Application\Comic;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Queue;
use Packages\Application\Comic\ComicUpdateInteractor;
use Packages\Domain\Comic\ComicStatus;
use Packages\UseCase\Comic\Exception\ComicAlreadyExistsException;
use Packages\UseCase\Comic\Exception\ComicNotFoundException;
use Packages\UseCase\Comic\Update\ComicUpdateRequest;
use Packages\UseCase\Comic\Update\ComicUpdateResponse;
use Tests\TestCase;

class ComicUpdateInteractorTest extends TestCase
{
    use RefreshDatabase;

    private ComicUpdateInteractor $interactor;

    public function setUp(): void
    {
        parent::setUp();
        $this->interactor = $this->app->make(ComicUpdateInteractor::class);
    }

    public function testHandleSuccess(): void
    {
        Queue::fake();
        $request = new ComicUpdateRequest(
            id: 1,
            key: 'test-key-1',
            name: 'test_name_1',
            status: ComicStatus::CLOSED->value
        );
        $response = $this->interactor->handle($request);
        $this->assertInstanceOf(ComicUpdateResponse::class, $response);
        $expected = [
            'comic' => [
                'id' => 1,
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

    public function testHandleFailureByNotFound(): void
    {
        $this->expectException(ComicNotFoundException::class);
        $request = new ComicUpdateRequest(
            id: PHP_INT_MAX,
            key: 'test-key-1',
            name: 'test_name_1',
            status: ComicStatus::CLOSED->value
        );
        $this->interactor->handle($request);
    }

    public function testHandleFailureByDuplicateKey(): void
    {
        $this->expectException(ComicAlreadyExistsException::class);
        $request = new ComicUpdateRequest(
            id: 1,
            key: 'default-key-2',
            name: 'test_name_1',
            status: ComicStatus::CLOSED->value
        );
        $this->interactor->handle($request);
    }
}
