<?php

declare(strict_types=1);

namespace Packages\UseCase\Comic\Show;

use Packages\UseCase\RequestInterface;

class ComicShowRequest implements RequestInterface
{
    public function __construct(
        public readonly int $id
    ) {}
}
