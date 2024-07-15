<?php

declare(strict_types=1);

namespace Packages\Domain\Comic;

use Illuminate\Database\Eloquent\Builder;

interface ComicRepositoryInterface
{
    public function find(ComicId $comicId): ?Comic;

    public function findByKey(ComicKey $comicKey, ?ComicId $ignoreComicId = null): ?Comic;

    public function paginate(Builder $query, int $perPage): Comics;

    public function create(Comic $comic): Comic;

    public function update(Comic $comic): Comic;

    public function delete(Comic $comic): void;
}
