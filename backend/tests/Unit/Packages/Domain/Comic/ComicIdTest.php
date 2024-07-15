<?php

declare(strict_types=1);

namespace Tests\Unit\Packages\Domain\Comic;

use Illuminate\Foundation\Testing\RefreshDatabase;
use InvalidArgumentException;
use Packages\Domain\Comic\ComicId;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class ComicIdTest extends TestCase
{
    use RefreshDatabase;

    #[DataProvider('provideCreateInstanceSuccess')]
    public function testCreateInstanceSuccess(int $id): void
    {
        $comicId = new ComicId($id);
        $this->assertInstanceOf(ComicId::class, $comicId);
    }

    #[DataProvider('provideCreateInstanceFailure')]
    public function testCreateInstanceFailure(mixed $id): void
    {
        $this->expectException(InvalidArgumentException::class);
        new ComicId($id);
    }

    public static function provideCreateInstanceSuccess(): array
    {
        return [
            [1],
            [PHP_INT_MAX],
        ];
    }

    public static function provideCreateInstanceFailure(): array
    {
        return [
            [0],
            [-1],
            ['1'],
            ['a'],
            [null],
        ];
    }
}
