<?php

declare(strict_types=1);

use Illuminate\Database\Eloquent\Builder;
use Packages\Infrastructure\QueryBuilder\Comic\Index\ComicSearchQueryBuilder;

test('build', function () {
    $queryBuilder = new ComicSearchQueryBuilder;
    $queryBuilder->setKey('default-key-1');
    $queryBuilder->setName('default_name_1');
    $queryBuilder->setStatus(['published']);
    $query = $queryBuilder->build();
    expect($query)->toBeInstanceOf(Builder::class);
});
