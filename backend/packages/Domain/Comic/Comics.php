<?php

declare(strict_types=1);

namespace Packages\Domain\Comic;

use Packages\Domain\AbstractEntities;

class Comics extends AbstractEntities
{
    protected function getEntityClass(): string
    {
        return Comic::class;
    }
}
