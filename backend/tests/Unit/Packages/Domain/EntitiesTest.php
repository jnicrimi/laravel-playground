<?php

declare(strict_types=1);

use Packages\Domain\Entities;
use Packages\Domain\Pagination;

describe('ArrayAccess', function () {
    test('offset exists', function (mixed $expected, mixed $offset) {
        expect(createEntities()->offsetExists($offset))->toBe($expected);
    })->with([
        [true, 'a'],
        [true, 'b'],
        [true, 'c'],
        [false, 'd'],
    ]);

    test('offset get', function (mixed $expected, mixed $offset) {
        expect(createEntities()->offsetGet($offset))->toBe($expected);
    })->with([
        ['A', 'a'],
        ['B', 'b'],
        ['C', 'c'],
        [null, 'd'],
    ]);

    test('offset set', function (mixed $offset, mixed $value) {
        expect(fn () => createEntities()->offsetSet($offset, $value))->toThrow(InvalidArgumentException::class);
    })->with([
        ['d', new class {}],
    ]);

    test('offset unset', function (mixed $expected, mixed $offset) {
        $entities = createEntities();
        $entities->offsetUnset($offset);
        expect($entities->count())->toBe($expected);
    })->with([
        [2, 'a'],
        [2, 'b'],
        [2, 'c'],
        [3, 'd'],
    ]);
});

test('count', function () {
    expect(createEntities()->count())->toBe(3);
});

test('set pagination', function () {
    $entities = createEntities();
    $entities->setPagination(createPagination());
})->throwsNoExceptions();

test('get pagination', function () {
    $entities = createEntities();
    $entities->setPagination(createPagination());
    expect($entities->getPagination())->toBeInstanceOf(Pagination::class);
});

test('get iterator', function () {
    expect(createEntities()->getIterator())->toBeInstanceOf(ArrayIterator::class);
});

function createEntities(): Entities
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
