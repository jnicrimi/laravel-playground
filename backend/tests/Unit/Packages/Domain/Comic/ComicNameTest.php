<?php

declare(strict_types=1);

use Packages\Domain\Comic\ComicName;

test('valid name creates instance', function (string $name) {
    expect(new ComicName($name))->toBeInstanceOf(ComicName::class);
})->with(['a', str_repeat('a', 255)]);

test('invalid name throws exception', function (mixed $name) {
    expect(fn () => new ComicName($name))->toThrow(InvalidArgumentException::class);
})->with(['', str_repeat('a', 256), 0, 1, null]);
