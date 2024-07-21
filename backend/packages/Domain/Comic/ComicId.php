<?php

declare(strict_types=1);

namespace Packages\Domain\Comic;

use Packages\Domain\ValueObject;

class ComicId extends ValueObject
{
    protected function validate(): bool
    {
        return $this->isNaturalNumber();
    }
}
