<?php

declare(strict_types=1);

use Carbon\Carbon;
use Illuminate\Support\Arr;
use Packages\Domain\Comic\Comic;
use Packages\Domain\Comic\ComicId;
use Packages\Domain\Comic\ComicIdIsNotSetException;
use Packages\Domain\Comic\ComicKey;
use Packages\Domain\Comic\ComicName;
use Packages\Domain\Comic\ComicStatus;

describe('creation', function () {
    test('valid arguments create instance', function (array $arguments) {
        expect(new Comic(
            Arr::get($arguments, 'id'),
            Arr::get($arguments, 'key'),
            Arr::get($arguments, 'name'),
            Arr::get($arguments, 'status'),
            Arr::get($arguments, 'created_at'),
            Arr::get($arguments, 'updated_at')
        ))->toBeInstanceOf(Comic::class);
    })->with('valid constructor arguments');

    test('invalid arguments throw TypeError', function (array $arguments) {
        expect(fn () => new Comic(
            Arr::get($arguments, 'id'),
            Arr::get($arguments, 'key'),
            Arr::get($arguments, 'name'),
            Arr::get($arguments, 'status'),
            Arr::get($arguments, 'created_at'),
            Arr::get($arguments, 'updated_at')
        ))->toThrow(TypeError::class);
    })->with('invalid constructor arguments');
});

describe('getters', function () {
    test('getId returns ComicId', function () {
        expect(createComic(defaultComicAttributes())->getId())->toBeInstanceOf(ComicId::class);
    });

    test('getId throws when id is null', function () {
        $comic = createComic(array_merge(defaultComicAttributes(), ['id' => null]));
        expect(fn () => $comic->getId())->toThrow(ComicIdIsNotSetException::class);
    });

    test('getKey returns ComicKey', function () {
        expect(createComic(defaultComicAttributes())->getKey())->toBeInstanceOf(ComicKey::class);
    });

    test('getName returns ComicName', function () {
        expect(createComic(defaultComicAttributes())->getName())->toBeInstanceOf(ComicName::class);
    });

    test('getStatus returns ComicStatus', function () {
        expect(createComic(defaultComicAttributes())->getStatus())->toBeInstanceOf(ComicStatus::class);
    });

    test('getCreatedAt returns Carbon', function () {
        expect(createComic(defaultComicAttributes())->getCreatedAt())->toBeInstanceOf(Carbon::class);
    });

    test('getUpdatedAt returns Carbon', function () {
        expect(createComic(defaultComicAttributes())->getUpdatedAt())->toBeInstanceOf(Carbon::class);
    });
});

describe('setters', function () {
    test('changeKey updates key', function () {
        $comic = createComic(defaultComicAttributes());
        $newKey = 'new-key';
        $comic->changeKey(new ComicKey($newKey));
        expect($comic->getKey()->getValue())->toBe($newKey);
    });

    test('changeName updates name', function () {
        $comic = createComic(defaultComicAttributes());
        $newName = 'new_name';
        $comic->changeName(new ComicName($newName));
        expect($comic->getName()->getValue())->toBe($newName);
    });

    test('changeStatus updates status', function () {
        $comic = createComic(defaultComicAttributes());
        $newStatus = 'draft';
        $comic->changeStatus(ComicStatus::from($newStatus));
        expect($comic->getStatus()->value)->toBe($newStatus);
    });
});

describe('behavior', function () {
    test('canDelete returns expected result', function (array $attributes, bool $expected) {
        expect(createComic($attributes)->canDelete())->toBe($expected);
    })->with('can delete cases');

    test('toArray returns attributes', function () {
        expect(createComic(defaultComicAttributes())->toArray())->toBe(defaultComicAttributes());
    });
});

dataset('valid constructor arguments', function () {
    $attrs = defaultComicAttributes();
    $default = [
        'id' => new ComicId(Arr::get($attrs, 'id')),
        'name' => new ComicName(Arr::get($attrs, 'name')),
        'key' => new ComicKey(Arr::get($attrs, 'key')),
        'status' => ComicStatus::from(Arr::get($attrs, 'status')),
        'created_at' => Carbon::parse(Arr::get($attrs, 'created_at')),
        'updated_at' => Carbon::parse(Arr::get($attrs, 'updated_at')),
    ];

    return [
        [$default],
        [array_merge($default, ['id' => null])],
        [array_merge($default, ['created_at' => null])],
        [array_merge($default, ['updated_at' => null])],
    ];
});

dataset('invalid constructor arguments', function () {
    $attrs = defaultComicAttributes();
    $default = [
        'id' => new ComicId(Arr::get($attrs, 'id')),
        'name' => new ComicName(Arr::get($attrs, 'name')),
        'key' => new ComicKey(Arr::get($attrs, 'key')),
        'status' => ComicStatus::from(Arr::get($attrs, 'status')),
        'created_at' => Carbon::parse(Arr::get($attrs, 'created_at')),
        'updated_at' => Carbon::parse(Arr::get($attrs, 'updated_at')),
    ];

    return [
        [array_merge($default, ['name' => null])],
        [array_merge($default, ['key' => null])],
        [array_merge($default, ['status' => null])],
    ];
});

dataset('can delete cases', function () {
    return [
        [
            array_merge(defaultComicAttributes(), ['status' => 'published']),
            false,
        ],
        [
            array_merge(defaultComicAttributes(), ['status' => 'draft']),
            false,
        ],
        [
            array_merge(defaultComicAttributes(), ['status' => 'closed']),
            true,
        ],
    ];
});
