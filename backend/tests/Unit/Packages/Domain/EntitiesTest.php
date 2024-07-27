<?php

declare(strict_types=1);

namespace Tests\Unit\Packages\Domain;

use ArrayIterator;
use Illuminate\Foundation\Testing\RefreshDatabase;
use InvalidArgumentException;
use Packages\Domain\Entities;
use Packages\Domain\Pagination;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\DoesNotPerformAssertions;
use Tests\TestCase;

class EntitiesTest extends TestCase
{
    use RefreshDatabase;

    #[DataProvider('provideOffsetExists')]
    public function testOffsetExists(mixed $expected, mixed $offset): void
    {
        $entities = $this->createEntities();
        $actual = $entities->offsetExists($offset);
        $this->assertSame($expected, $actual);
    }

    #[DataProvider('provideOffsetGet')]
    public function testOffsetGet(mixed $expected, mixed $offset): void
    {
        $entities = $this->createEntities();
        $actual = $entities->offsetGet($offset);
        $this->assertSame($expected, $actual);
    }

    #[DataProvider('provideOffsetSet')]
    public function testOffsetSet(mixed $offset, mixed $value): void
    {
        $this->expectException(InvalidArgumentException::class);
        $entities = $this->createEntities();
        $entities->offsetSet($offset, $value);
    }

    #[DataProvider('provideOffsetUnset')]
    public function testOffsetUnset(mixed $expected, mixed $offset): void
    {
        $entities = $this->createEntities();
        $entities->offsetUnset($offset);
        $actual = $entities->count();
        $this->assertSame($actual, $expected);
    }

    public function testCount(): void
    {
        $entities = $this->createEntities();
        $actual = $entities->count();
        $expected = 3;
        $this->assertSame($actual, $expected);
    }

    #[DoesNotPerformAssertions]
    public function testSetPagination(): void
    {
        $pagination = $this->createPagination();
        $entities = $this->createEntities();
        $entities->setPagination($pagination);
    }

    public function testGetPagination(): void
    {
        $pagination = $this->createPagination();
        $entities = $this->createEntities();
        $entities->setPagination($pagination);
        $pagination = $entities->getPagination();
        $this->assertInstanceOf(Pagination::class, $pagination);
    }

    public function testGetIterator(): void
    {
        $entities = $this->createEntities();
        $iterator = $entities->getIterator();
        $this->assertInstanceOf(ArrayIterator::class, $iterator);
    }

    public static function provideOffsetExists(): array
    {
        return [
            [true, 'a'],
            [true, 'b'],
            [true, 'c'],
            [false, 'd'],
        ];
    }

    public static function provideOffsetGet(): array
    {
        return [
            ['A', 'a'],
            ['B', 'b'],
            ['C', 'c'],
            [null, 'd'],
        ];
    }

    public static function provideOffsetSet(): array
    {
        return [
            ['d', new class {}],
        ];
    }

    public static function provideOffsetUnset(): array
    {
        return [
            [2, 'a'],
            [2, 'b'],
            [2, 'c'],
            [3, 'd'],
        ];
    }

    private function createEntities(): Entities
    {
        return new class extends Entities
        {
            protected array $entities = [
                'a' => 'A',
                'b' => 'B',
                'c' => 'C',
            ];

            protected function getEntityClass(): string
            {
                return 'entities';
            }
        };
    }

    private function createPagination(): Pagination
    {
        $perPage = 5;
        $currentPage = 1;
        $lastPage = 2;
        $total = 10;
        $firstItem = 1;
        $lastItem = 5;

        return new Pagination(
            $perPage,
            $currentPage,
            $lastPage,
            $total,
            $firstItem,
            $lastItem
        );
    }
}
