<?php

declare(strict_types=1);

use App\Models\Comic as ComicModel;
use Carbon\Carbon;
use Packages\Domain\Comic\Comic;
use Packages\Domain\Comic\ComicId;
use Packages\Domain\Comic\ComicIdIsNotSetException;
use Packages\Domain\Comic\ComicKey;
use Packages\Domain\Comic\ComicName;
use Packages\Domain\Comic\Comics;
use Packages\Domain\Comic\ComicStatus;
use Packages\Infrastructure\QueryBuilder\Comic\Index\ComicSearchQueryBuilder;
use Packages\Infrastructure\Repository\Comic\ComicRepository;

beforeEach(function () {
    $this->repository = $this->app->make(ComicRepository::class);
});

describe('find', function () {
    test('success', function () {
        $comic = $this->repository->find(new ComicId(1));
        expect($comic)->toBeInstanceOf(Comic::class);
    });

    test('failure', function () {
        $comic = $this->repository->find(new ComicId(PHP_INT_MAX));
        expect($comic)->toBeNull();
    });

    test('by key success', function () {
        $comic = $this->repository->findByKey(new ComicKey('default-key-1'));
        expect($comic)->toBeInstanceOf(Comic::class);
    });

    test('by key failure', function (string $comicKey, ?int $ignoreComicId) {
        $comicKey = new ComicKey($comicKey);
        if ($ignoreComicId !== null) {
            $ignoreComicId = new ComicId($ignoreComicId);
        }
        $comic = $this->repository->findByKey($comicKey, $ignoreComicId);
        expect($comic)->toBeNull();
    })->with([
        [
            'comicKey' => 'dummy',
            'ignoreComicId' => null,
        ],
        [
            'comicKey' => 'default-key-1',
            'ignoreComicId' => 1,
        ],
    ]);
});

test('paginate', function () {
    $queryBuilder = new ComicSearchQueryBuilder;
    $queryBuilder->setKey('default-key-1');
    $queryBuilder->setName('default_name_1');
    $queryBuilder->setStatus(['published']);
    $query = $queryBuilder->build();
    $comics = $this->repository->paginate($query, 5);
    expect($comics)->toBeInstanceOf(Comics::class);
});

describe('create', function () {
    test('success', function () {
        $comic = $this->repository->create(new Comic(
            null,
            new ComicKey('key'),
            new ComicName('name'),
            ComicStatus::from('draft'),
            null,
            null
        ));
        expect($comic)->toBeInstanceOf(Comic::class);
    });

    test('failure', function () {
        expect(fn () => $this->repository->create(new Comic(
            new ComicId(1),
            new ComicKey('key'),
            new ComicName('name'),
            ComicStatus::from('published'),
            null,
            null
        )))->toThrow(Exception::class, 'ComicId is already set.');
    });
});

describe('update', function () {
    test('success', function () {
        $comic = $this->repository->update(new Comic(
            new ComicId(1),
            new ComicKey('key'),
            new ComicName('name'),
            ComicStatus::from('published'),
            Carbon::parse('2023-01-01 00:00:00'),
            Carbon::parse('2023-12-31 23:59:59')
        ));
        expect($comic)->toBeInstanceOf(Comic::class);
    });

    test('failure', function () {
        expect(fn () => $this->repository->update(new Comic(
            null,
            new ComicKey('key'),
            new ComicName('name'),
            ComicStatus::from('published'),
            null,
            null
        )))->toThrow(ComicIdIsNotSetException::class);
    });
});

describe('delete', function () {
    test('success', function () {
        $comic = $this->repository->modelToEntity(ComicModel::find(3));
        expect($comic->canDelete())->toBeTrue('comic cannot be deleted.');
        $this->repository->delete($comic);
        expect(ComicModel::find(3))->toBeNull();
    });
});

test('model to entity', function () {
    $comic = $this->repository->modelToEntity(ComicModel::find(1));
    expect($comic)->toBeInstanceOf(Comic::class);
});
