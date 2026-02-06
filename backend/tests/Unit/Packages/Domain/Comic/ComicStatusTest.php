<?php

declare(strict_types=1);

use Packages\Domain\Comic\ComicStatus;

test('cases returns all statuses', function () {
    expect(ComicStatus::cases())->toHaveCount(3);
});

describe('equals', function () {
    test('same status returns true', function (ComicStatus $comicStatus, ComicStatus $expected) {
        expect($comicStatus->equals($expected))->toBeTrue();
    })->with([
        [ComicStatus::PUBLISHED, ComicStatus::PUBLISHED],
        [ComicStatus::DRAFT, ComicStatus::DRAFT],
        [ComicStatus::CLOSED, ComicStatus::CLOSED],
    ]);

    test('different status returns false', function (ComicStatus $comicStatus, ComicStatus $expected) {
        expect($comicStatus->equals($expected))->toBeFalse();
    })->with('different statuses');
});

describe('description', function () {
    test('returns correct label', function (ComicStatus $comicStatus, string $expected) {
        expect($comicStatus->description())->toEqual($expected);
    })->with([
        [ComicStatus::PUBLISHED, '公開'],
        [ComicStatus::DRAFT, '下書き'],
        [ComicStatus::CLOSED, '非公開'],
    ]);

    test('does not match wrong label', function (ComicStatus $comicStatus, string $expected) {
        expect($comicStatus->description())->not->toEqual($expected);
    })->with([
        [ComicStatus::PUBLISHED, 'dummy'],
        [ComicStatus::DRAFT, 'dummy'],
        [ComicStatus::CLOSED, 'dummy'],
    ]);
});

dataset('different statuses', function () {
    return [
        [ComicStatus::PUBLISHED, ComicStatus::DRAFT],
        [ComicStatus::PUBLISHED, ComicStatus::CLOSED],
        [ComicStatus::DRAFT, ComicStatus::PUBLISHED],
        [ComicStatus::DRAFT, ComicStatus::CLOSED],
        [ComicStatus::CLOSED, ComicStatus::PUBLISHED],
        [ComicStatus::CLOSED, ComicStatus::DRAFT],
    ];
});
