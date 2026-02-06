<?php

declare(strict_types=1);

use Packages\Domain\Comic\Comics;

test('can add valid comics', function () {
    $comics = new Comics;
    $comics[] = createComic(defaultComicAttributes());
    $comics[] = createComic(array_merge(defaultComicAttributes(), ['id' => 2]));
    expect($comics)->toBeInstanceOf(Comics::class);
});

test('adding null throws TypeError', function () {
    expect(function () {
        $comics = new Comics;
        $comics[] = createComic(defaultComicAttributes());
        $comics[] = null;
    })->toThrow(TypeError::class);
});
