<?php

declare(strict_types=1);

namespace Packages\Domain\Comic;

use Packages\Domain\AbstractValueObject;

class ComicId extends AbstractValueObject
{
    protected function validate(): bool
    {
        return $this->isNaturalNumber();
    }
}
