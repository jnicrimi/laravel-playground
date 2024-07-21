<?php

declare(strict_types=1);

namespace Packages\Domain;

abstract class Entity
{
    /**
     * @var string
     */
    public const DATE_FORMAT = 'Y-m-d H:i:s';

    abstract public function toArray(): array;
}
