<?php

declare(strict_types=1);

namespace Packages\Domain;

interface EntityInterface
{
    public function toArray(): array;
}
