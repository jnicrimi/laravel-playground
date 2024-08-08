<?php

declare(strict_types=1);

namespace Packages\Infrastructure\QueryBuilder;

use Illuminate\Database\Eloquent\Builder;

abstract class QueryBuilder
{
    abstract public function build(): Builder;
}
