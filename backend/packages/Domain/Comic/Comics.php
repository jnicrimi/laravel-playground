<?php

declare(strict_types=1);

namespace Packages\Domain\Comic;

use Packages\Domain\Entities;

class Comics extends Entities
{
    protected function getEntityClass(): string
    {
        return Comic::class;
    }
}
