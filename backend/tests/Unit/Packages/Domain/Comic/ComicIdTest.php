<?php

declare(strict_types=1);

use Packages\Domain\Comic\ComicId;

test('valid id creates instance', function (int $id) {
    expect(new ComicId($id))->toBeInstanceOf(ComicId::class);
})->with([1, PHP_INT_MAX]);

test('invalid id throws exception', function (mixed $id) {
    expect(fn () => new ComicId($id))->toThrow(InvalidArgumentException::class);
})->with([0, -1, '1', 'a', null]);
