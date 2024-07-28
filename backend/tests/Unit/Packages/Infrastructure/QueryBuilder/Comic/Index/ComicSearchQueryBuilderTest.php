<?php

declare(strict_types=1);

namespace Tests\Unit\Packages\Infrastructure\QueryBuilder\Comic\Index;

use Illuminate\Database\Eloquent\Builder;
use Packages\Infrastructure\QueryBuilder\Comic\Index\ComicSearchQueryBuilder;
use Tests\TestCase;

class ComicSearchQueryBuilderTest extends TestCase
{
    public function testBuild(): void
    {
        $queryBuilder = new ComicSearchQueryBuilder;
        $queryBuilder->setKey('default-key-1');
        $queryBuilder->setName('default_name_1');
        $queryBuilder->setStatus(['published']);
        $query = $queryBuilder->build();
        $this->assertInstanceOf(Builder::class, $query);
    }
}
