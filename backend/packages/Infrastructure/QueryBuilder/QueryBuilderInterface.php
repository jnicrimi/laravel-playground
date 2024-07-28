<?php

declare(strict_types=1);

namespace Packages\Infrastructure\QueryBuilder;

use Illuminate\Database\Eloquent\Builder;

interface QueryBuilderInterface
{
    public function build(): Builder;
}
