<?php

declare(strict_types=1);

use Packages\Domain\Comic\ComicKey;

test('valid key creates instance', function (string $key) {
    expect(new ComicKey($key))->toBeInstanceOf(ComicKey::class);
})->with('valid keys');

test('invalid key throws exception', function (mixed $key) {
    expect(fn () => new ComicKey($key))->toThrow(InvalidArgumentException::class);
})->with('invalid keys');

dataset('valid keys', function () {
    return [
        ['a'],
        ['-'],
        [randomKey(255)],
    ];
});

dataset('invalid keys', function () {
    return [
        [''],
        ['_'],
        ['A'],
        ['あ'],
        [randomKey(256)],
        [0],
        [1],
        [null],
    ];
});

function randomKey(int $length): string
{
    $str = str_repeat('0123456789abcdefghijklmnopqrstuvwxyz-', $length);
    $str = str_shuffle($str);

    return substr($str, 0, $length);
}
