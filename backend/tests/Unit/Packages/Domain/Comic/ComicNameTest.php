<?php

declare(strict_types=1);

namespace Tests\Unit\Packages\Domain\Comic;

use Illuminate\Foundation\Testing\RefreshDatabase;
use InvalidArgumentException;
use Packages\Domain\Comic\ComicName;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class ComicNameTest extends TestCase
{
    use RefreshDatabase;

    #[DataProvider('provideCreateInstanceSuccess')]
    public function testCreateInstanceSuccess(string $name): void
    {
        $comicName = new ComicName($name);
        $this->assertInstanceOf(ComicName::class, $comicName);
    }

    #[DataProvider('provideCreateInstanceFailure')]
    public function testCreateInstanceFailure(mixed $name): void
    {
        $this->expectException(InvalidArgumentException::class);
        new ComicName($name);
    }

    public static function provideCreateInstanceSuccess(): array
    {
        return [
            ['a'],
            [str_repeat('a', 255)],
        ];
    }

    public static function provideCreateInstanceFailure(): array
    {
        return [
            [''],
            [str_repeat('a', 256)],
            [0],
            [1],
            [null],
        ];
    }
}
