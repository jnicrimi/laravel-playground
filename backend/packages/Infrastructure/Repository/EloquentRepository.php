<?php

declare(strict_types=1);

namespace Packages\Infrastructure\Repository;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Packages\Domain\EntityInterface;
use Packages\Domain\Pagination;

abstract class EloquentRepository implements EloquentRepositoryInterface
{
    abstract public function modelToEntity(Model $model): EntityInterface;

    protected function lengthAwarePaginatorToPagination(LengthAwarePaginator $lengthAwarePaginator): Pagination
    {
        return new Pagination(
            $lengthAwarePaginator->perPage(),
            $lengthAwarePaginator->currentPage(),
            $lengthAwarePaginator->lastPage(),
            $lengthAwarePaginator->total(),
            $lengthAwarePaginator->firstItem(),
            $lengthAwarePaginator->lastItem()
        );
    }
}
