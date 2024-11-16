<?php

declare(strict_types=1);

namespace Packages\Domain;

trait EnumMatchable
{
    public function equals(self $enum): bool
    {
        return $this->value === $enum->value;
    }
}
