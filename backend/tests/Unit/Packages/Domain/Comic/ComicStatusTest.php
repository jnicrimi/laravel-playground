<?php

declare(strict_types=1);

namespace Tests\Unit\Packages\Domain\Comic;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Packages\Domain\Comic\ComicStatus;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class ComicStatusTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @var int
     */
    public const CASE_COUNT = 3;

    public function test_cases(): void
    {
        $this->assertCount(self::CASE_COUNT, ComicStatus::cases());
    }

    #[DataProvider('provideEqualsSuccess')]
    public function test_equals_success(ComicStatus $comicStatus, ComicStatus $expected): void
    {
        $this->assertTrue($comicStatus->equals($expected));
    }

    #[DataProvider('provideEqualsFailure')]
    public function test_equals_failure(ComicStatus $comicStatus, ComicStatus $expected): void
    {
        $this->assertFalse($comicStatus->equals($expected));
    }

    #[DataProvider('provideDescriptionSuccess')]
    public function test_description_success(ComicStatus $comicStatus, string $expected): void
    {
        $this->assertEquals($expected, $comicStatus->description());
    }

    #[DataProvider('provideDescriptionFailure')]
    public function test_description_failure(ComicStatus $comicStatus, string $expected): void
    {
        $this->assertNotEquals($expected, $comicStatus->description());
    }

    public static function provideEqualsSuccess(): array
    {
        return [
            [ComicStatus::PUBLISHED, ComicStatus::PUBLISHED],
            [ComicStatus::DRAFT, ComicStatus::DRAFT],
            [ComicStatus::CLOSED, ComicStatus::CLOSED],
        ];
    }

    public static function provideEqualsFailure(): array
    {
        return [
            [ComicStatus::PUBLISHED, ComicStatus::DRAFT],
            [ComicStatus::PUBLISHED, ComicStatus::CLOSED],
            [ComicStatus::DRAFT, ComicStatus::PUBLISHED],
            [ComicStatus::DRAFT, ComicStatus::CLOSED],
            [ComicStatus::CLOSED, ComicStatus::PUBLISHED],
            [ComicStatus::CLOSED, ComicStatus::DRAFT],
        ];
    }

    public static function provideDescriptionSuccess(): array
    {
        return [
            [ComicStatus::PUBLISHED, '公開'],
            [ComicStatus::DRAFT, '下書き'],
            [ComicStatus::CLOSED, '非公開'],
        ];
    }

    public static function provideDescriptionFailure(): array
    {
        return [
            [ComicStatus::PUBLISHED, 'dummy'],
            [ComicStatus::DRAFT, 'dummy'],
            [ComicStatus::CLOSED, 'dummy'],
        ];
    }
}
