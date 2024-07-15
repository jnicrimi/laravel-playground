<?php

declare(strict_types=1);

namespace Tests\Unit\Packages\Domain\Comic;

use Illuminate\Foundation\Testing\RefreshDatabase;
use InvalidArgumentException;
use Packages\Domain\Comic\ComicKey;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class ComicKeyTest extends TestCase
{
    use RefreshDatabase;

    #[DataProvider('provideCreateInstanceSuccess')]
    public function testCreateInstanceSuccess(string $key): void
    {
        $comicKey = new ComicKey($key);
        $this->assertInstanceOf(ComicKey::class, $comicKey);
    }

    #[DataProvider('provideCreateInstanceFailure')]
    public function testCreateInstanceFailure(mixed $key): void
    {
        $this->expectException(InvalidArgumentException::class);
        new ComicKey($key);
    }

    public static function provideCreateInstanceSuccess(): array
    {
        return [
            ['a'],
            ['-'],
            [self::randomKey(255)],
        ];
    }

    public static function provideCreateInstanceFailure(): array
    {
        return [
            [''],
            ['_'],
            ['A'],
            ['あ'],
            [self::randomKey(256)],
            [0],
            [1],
            [null],
        ];
    }

    private static function randomKey(int $length): string
    {
        $str = str_repeat('0123456789abcdefghijklmnopqrstuvwxyz-', $length);
        $str = str_shuffle($str);

        return substr($str, 0, $length);
    }
}
